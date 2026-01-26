<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\ShippingAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Flasher\Toastr\Prime\toastr;
use function PHPUnit\Framework\isEmpty;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = ShippingAddress::where('user_id', $user->id)->get();
        $defaultAddress = $addresses->where('default', 1)->first();
        if (is_null($addresses) || is_null($defaultAddress)) {

            toastr()->error('Vui lòng thêm địa chỉ giao hàng');
            return redirect()->route('account');
        }

        $cartItem = CartItem::where('user_id', $user->id)->with('product')->get();
        $totalPrice = $cartItem->sum(fn($item) => $item->quantity * $item->product->price);

        return view('clients.pages.checkout', compact('addresses', 'defaultAddress', 'cartItem', 'totalPrice'));
    }

    //lấy địa chỉ hiển thị lên giao diện
    public function getAddresses(Request $request)
    {
        $address = ShippingAddress::where('id', $request->address_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy địa chỉ',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $address,
        ]);
    }

    // apply mã khuyến mãi
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $user = Auth::user();

        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống',
            ]);
        }

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi không tồn tại'
            ]);
        }

        if (!$coupon->isActive()) {
            return response()->json(['success' => false, 'message' => 'Mã khuyến mãi đã bị vô hiệu']);
        }

        if ($coupon->isExpired()) {
            return response()->json(['success' => false, 'message' => 'Mã khuyến mãi đã hết hạn']);
        }

        if ($coupon->isUsageLimitReached()) {
            return response()->json(['success' => false, 'message' => 'Mã khuyến mãi đã hết lượt sử dụng']);
        }

        $totalProductPrice = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        if ($coupon->min_order_value && $totalProductPrice < $coupon->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng chưa đạt giá trị tối thiểu'
            ]);
        }

        //Tính tiền giảm
        if ($coupon->type == 'percent') {
            $discount = ($totalProductPrice * $coupon->value) / 100;
        } else {
            $discount = $coupon->value;
        }

        $discount = min($discount, $totalProductPrice);
        $finalPrice = $totalProductPrice - $discount + 25000;

        // Lưu tạm vào session => đơn hàng đc đặt thành công mới giảm giá trị của các trường limit trong coupon
        session([
            'coupon' => [
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'discount_amount' => $discount,
                'final_price' => $finalPrice,
            ]
        ]);

        return response()->json([
            'success' => true,
            'discount' => number_format($discount, 0, ',', '.'),
            'final_price' => number_format($finalPrice, 0, ',', '.'),
            'message' => 'Áp dụng mã khuyến mãi thành công'
        ]);
    }

    public function cancelCoupon()
    {
        $coupon = session('coupon', []);
        $totalPrice = $coupon['final_price'] + $coupon['discount_amount'];

        session()->forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Đã hủy mã khuyến mãi',
            'totalPrice' => number_format($totalPrice, 0, ',', '.'),
        ]);
    }

    //Đặt hàng
    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required',
            'payment_method' => 'required',
        ]);

        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống');
        }

        DB::beginTransaction();
        try {

            //Lấy coupon trong session
            $couponSession = session('coupon');

            //Tạo đơn hàng
            $order = new Order();

            $order->user_id = $user->id;
            $order->shipping_address_id = $request->address_id;

            $originTotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->price) + 25000;
            $order->total_price = $originTotal;
            $order->discount_amount = $couponSession['discount_amount'] ?? 0;
            $order->final_price = $originTotal - ($couponSession['discount_amount'] ?? 0);
            $order->coupon_id = $couponSession['coupon_id'] ?? null;
            $order->coupon_code = $couponSession['coupon_code'] ?? null;
            $order->status = 'pending';
            $order->save();

            if ($couponSession) {
                $updated = Coupon::where('id', $couponSession['coupon_id'])
                    ->whereColumn('used_count', '<', 'usage_limit')
                    ->increment('used_count');

                if ($updated === 0) {
                    throw new Exception('Mã khuyến mãi đã hết lượt sử dụng');
                }

                session()->forget('coupon');
            }

            // Tạo OrderStatusHistory
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'changed_at' => now(),
                'note' => 'Khách hàng tạo đơn hàng'
            ]);

            foreach ($cartItems as $item) {
                //Tạo OrderItem
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);

                $product = $item->product;

                if ($product->stock < $item->quantity) {
                    throw new Exception("Sản phẩm {$product->name} không đủ hàng trong kho.");
                }

                $product->stock -= $item->quantity;
                $product->save();
            }

            //Tạo Payment
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $order->final_price,
                'status' => 'pending',
                'paid_at' => null,
            ]);

            //Xóa sản phẩm khỏi giỏ hàng
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            toastr()->success('Đặt hàng thành công !');
            return redirect()->route('account');
        } catch (\Exception $e) {

            DB::rollBack();

            // dd($e->getMessage());
            toastr()->error('Có lỗi xảy ra, vui lòng thử lại');
            return redirect()->route('checkout.index');
        }
    }
}
