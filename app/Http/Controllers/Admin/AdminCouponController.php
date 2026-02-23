<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminCouponController extends Controller
{
    //
    public function index()
    {
        $coupons = Coupon::select(
            'id',
            'code',
            'type',
            'value',
            'min_order_value',
            'usage_limit',
            'used_count',
            'expires_at',
            'is_active'
        )->orderByDesc('created_at')->get();

        return view('admin.pages.coupons', compact('coupons'));
    }

    public function showFormAddCoupon()
    {
        return view('admin.pages.coupon-add');
    }

    public function addCoupon(Request $request)
    {
        $request->validate([
            'code'            => 'required|string|max:50|unique:coupons,code',
            'type'            => 'required|in:fixed,percent',
            'value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type === 'percent' && $value > 100) {
                        $fail('Phần trăm giảm giá không được vượt quá 100%.');
                    }
                },
            ],
            'min_order_value' => 'required|numeric|min:0',
            'usage_limit'     => 'nullable|integer|min:1',
            'expires_at'      => 'nullable|date|after:today',
        ], [
            'code.required'   => 'Vui lòng nhập mã giảm giá.',
            'code.unique'     => 'Mã giảm giá này đã tồn tại trên hệ thống.',
            'type.required'   => 'Vui lòng chọn loại giảm giá.',
            'value.required'  => 'Vui lòng nhập giá trị giảm.',
            'expires_at.after' => 'Ngày hết hạn phải lớn hơn ngày hiện tại.',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                Coupon::create([
                    'code'            => strtoupper($request->code),
                    'type'            => $request->type,
                    'value'           => $request->value,
                    'min_order_value' => $request->min_order_value ?? 0,
                    'usage_limit'     => $request->usage_limit,
                    'used_count'      => 0,
                    'expires_at'      => $request->expires_at,
                    'is_active'       => $request->has('is_active') ? 1 : 0,
                ]);

                toastr()->success('Mã giảm giá đã được tạo thành công!');
                return redirect()->route('admin.coupons.add');
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function updateCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id'       => 'required|exists:coupons,id',
            'code'            => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->ignore($request->coupon_id)
            ],
            'type'            => 'required|in:fixed,percent',
            'value'           => 'required|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'usage_limit'     => 'nullable|integer|min:0',
            'expires_at'      => 'nullable|date',
        ], [
            'code.required'   => 'Mã không được để trống.',
            'code.unique'     => 'Mã này đã tồn tại.',
            'value.required'  => 'Giá trị không được để trống.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request) {
                $coupon = Coupon::findOrFail($request->coupon_id);

                $coupon->update([
                    'code'            => strtoupper($request->code),
                    'type'            => $request->type,
                    'value'           => $request->value,
                    'min_order_value' => $request->min_order_value,
                    'usage_limit'     => $request->usage_limit,
                    'expires_at'      => $request->expires_at,
                    'is_active'       => $request->is_active == '1' ? 1 : 0,
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Cập nhật mã giảm giá thành công!',
                    'data'    => $coupon
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteCoupon(Request $request)
    {
        $request->validate([
            'coupon_id' => 'required|exists:coupons,id',
        ]);

        try {
            $coupon = Coupon::findOrFail($request->coupon_id);

            $existsInOrder = Order::where('coupon_id', $coupon->id)->exists();

            if ($existsInOrder) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Không thể xóa! Mã giảm giá này đã có trong lịch sử đơn hàng.'
                ], 400);
            }

            $coupon->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Mã giảm giá đã được xóa vĩnh viễn!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
