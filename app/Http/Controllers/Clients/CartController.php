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
}
