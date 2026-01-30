<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index() {
        $user = Auth::user();
        $wishlist = Wishlist::with('product')->where('user_id', $user->id)->get();
        return view('clients.pages.wishlist', ['wishlist' => $wishlist]);
    }

    public function addToWishlist(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ], [
            'product_id.required' => 'Không tìm thấy sản phẩm này',
            'product_id.exists' => 'Sản phẩm không tồn tại',
        ]);

        $user = Auth::user();

        $existingProductInWishlist = Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id)->exists();

        if($existingProductInWishlist) {
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
}
