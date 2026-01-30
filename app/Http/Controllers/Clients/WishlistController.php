<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wishlist = Wishlist::with('product')->where('user_id', $user->id)->get();
        return view('clients.pages.wishlist', ['wishlist' => $wishlist]);
    }

    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ], [
            'product_id.required' => 'Không tìm thấy sản phẩm này',
            'product_id.exists' => 'Sản phẩm không tồn tại',
        ]);

        $user = Auth::user();

        $existingProductInWishlist = Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id)->exists();

        if ($existingProductInWishlist) {
            return response()->json([
                'status' => false,
                'message' => 'Sản phẩm đã tồn tại trong danh sách yêu thích',
            ]);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm sản phẩm vào danh sách yêu thích thành công',
        ]);
    }

    public function removeFromWishlist(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        try {
            $user = Auth::user();

            $wishlistItem = Wishlist::where('user_id', $user->id)
                ->where('product_id', $request->product_id)->first();

            if (!$wishlistItem) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Sản phẩm không có trong danh sách yêu thích của bạn.'
                ], 404);
            }

            $wishlistItem->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xóa sản phẩm khỏi danh sách yên thích thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'
            ], 500);
        }
    }
}
