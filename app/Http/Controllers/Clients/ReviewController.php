<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function showReview(Product $product) {
        return view('clients.components.includes.review-list', compact('product'))->render();
    }

    public function createReview(Request $request) {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ], [
            'product_id.required' => 'ID sản phẩm là bắt buộc.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'rating.required' => 'Đánh giá sao là bắt buộc.',
            'rating.integer' => 'Đánh giá sao phải là một số nguyên.',
            'rating.min' => 'Đánh giá sao phải từ 1 đến 5.',
            'rating.max' => 'Đánh giá sao phải từ 1 đến 5.',
            'comment.string' => 'Bình luận phải là một chuỗi ký tự.',
        ]);

        $user = Auth::user();

        $review = new Review();
        $review->user_id = $user->id;
        $review->product_id = $request->product_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return response()->json([
            'status' => true,
            'message' => 'Đánh giá của bạn đã được gửi thành công.',
        ], 201);
    }
}
