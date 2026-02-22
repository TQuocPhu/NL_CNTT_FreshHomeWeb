<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->merge(['quantity' => $request->quantity]);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return response()->json([
                'status' => false,
                'message' => 'Số lượng vượt quá tồn kho'
            ], 400);
        }

        //Nếu người dùng đã đăng nhập => lưu vào db
        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }
            $cartCount = CartItem::where('user_id', Auth::id())->count();
        } else {
            //nếu người dùng chưa đăng nhập => lưu vào session
            $cart = session()->get('cart', []);

            // nếu cart bị lỗi cấu trúc cũ => reset
            if (!empty($cart) && array_key_first($cart) === 0 && is_array($cart[0])) {
                session()->forget('cart');
                $cart = [];
            }

            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] += (int) $request->quantity;
            } else {
                $cart[$request->product_id] = [
                    'product_id' => $request->product_id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $request->quantity,
                    'stock' => $product->stock,
                    'image' => $product->image_url,
                    // 'image' => $product->images->first()->image ?? 'uploads/products/default_product_img.jpg',
                ];
            }

            session()->put('cart', $cart);
            $cartCount = count($cart);
        }

        return response()->json([
            'status' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
            'cart_count' => $cartCount,
        ]);
    }

    public function getCartViewData()
    {
        $items = [];
        $subTotal = 0;

        if (Auth::check()) {
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
            foreach ($cartItems as $item) {
                $items[] = [
                    'product'  => $item->product,
                    'quantity' => $item->quantity,
                ];
                $subTotal += $item->quantity * $item->product->price;
            }
        } else {
            $cart = session('cart', []);
            $products = Product::whereIn('id', array_keys($cart))
                ->get()
                ->keyBy('id');

            foreach ($cart as $item) {
                $product = $products[$item['product_id']] ?? null;

                if (!$product) continue;

                $items[] = [
                    'product'  => $product,
                    'quantity' => $item['quantity'],
                ];
                $subTotal += $item['quantity'] * $product->price;
            }
        }
        return [
            'items' => $items,
            'subTotal' => $subTotal,
            'shipping' => 25000,
            'grandTotal' => $subTotal + 25000,
        ];
    }

    public function loadMiniCart()
    {
        return response()->json([
            'status' => true,
            'html' => view(
                'clients.components.includes.mini-cart',
                $this->getCartViewData()
            )->render(),
        ]);
    }

    public function removeFromMiniCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->where('product_id', $request->product_id)->delete();

            $cartCount = CartItem::where('user_id', Auth::id())->count();
        } else {
            $cart = session('cart', []);
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);

            $cartCount = count($cart);
        }

        //load lại mini cart
        $miniCartHtml = view(
            'clients.components.includes.mini-cart',
            $this->getCartViewData()
        )->render();

        return response()->json([
            'status' => true,
            'message' => 'Xóa sản phẩm trong mini cart thành công',
            'cart_count' => $cartCount,
            'html' => $miniCartHtml,
        ]);
    }


    //Trang giỏ hàng
    public function showCartDetail()
    {
        return view('clients.pages.cart', $this->getCartViewData());
    }

    //update
    public function updateCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return response()->json([
                'error' => 'Số lượng vượt quá tồn kho'
            ], 422);
        }

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->update(['quantity' => $request->quantity]);
        } else {
            $cart = session('cart', []);

            if (!isset($cart[$request->product_id])) {
                return response()->json(['error' => 'Không tồn tại sản phẩm'], 404);
            }

            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        $cartData = $this->getCartViewData();
        $itemSubTotal = $request->quantity * $product->price;

        return response()->json([
            'quantity' => $request->quantity,
            'item_subtotal' => number_format($itemSubTotal, 2, ',', '.'),
            'total' => number_format($cartData['subTotal'], 2, ',', '.'),
            'grandTotal' => number_format($cartData['grandTotal'], 2, ',', '.'),
        ]);
    }

    public function removeCartItemFromDetailCart(Request $request)
    {
        $productId = $request->product_id;

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)->delete();
        } else {
            $cart = session('cart', []);
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $cartData = $this->getCartViewData();
        
        return response()->json([
            'total' => number_format($cartData['subTotal'], 2, ',', '.'),
            'grandTotal' => number_format($cartData['grandTotal'], 2, ',', '.'),
            'empty' => count($cartData['items']) === 0
        ]);
    }
}
