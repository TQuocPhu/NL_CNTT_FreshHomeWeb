<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
