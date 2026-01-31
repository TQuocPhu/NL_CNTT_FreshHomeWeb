<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchProductController extends Controller
{
    public function index(Request $request)
    {

        $keyword = trim($request->input('keyword'));

        if (empty($keyword)) {
            return redirect()->back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
        }

        $products = Product::query()
            ->where(function ($query) use ($keyword) {
                // 1. Ưu tiên tìm chính xác cả cụm từ trước
                $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");

                // 2. Tách từ để tìm kiếm mở rộng (nếu keyword có nhiều từ)
                $words = explode(' ', $keyword);
                if (count($words) > 1) {
                    foreach ($words as $word) {
                        if (mb_strlen($word) > 2) { // Bỏ qua từ quá ngắn như 'và', 'ăn'
                            $query->orWhere('name', 'LIKE', "%{$word}%");
                        }
                    }
                }
            })
            ->paginate(12)
            ->withQueryString();

        $products->appends(['keyword' => $keyword]);

        return view('clients.pages.products-search', [
            'products' => $products,
            'keyword' => $keyword
        ]);
    }

    public function searchByImage(Request $request)
    {
        if (!$request->hasFile('search_image')) {
            return response()->json(['error' => 'Vui lòng chọn hình ảnh.'], 400);
        }

        try {
            $image = $request->file('search_image');

            /** @var \Illuminate\Http\Client\Response $response */
            // Gọi đến Python Service (Cổng 8001)
            $response = Http::attach(
                'file',
                file_get_contents($image->path()),
                $image->getClientOriginalName()
            )->post('http://127.0.0.1:8001/predict');

            if ($response->successful()) {
                $keyword = $response->json()['keyword'] ?? '';

                if (empty($keyword)) {
                    return response()->json(['error' => 'Không nhận diện được vật thể.'], 404);
                }

                // // Xử lý từ khóa: Tách thành mảng để tìm kiếm bao phủ (VD: "Sữa tươi organic" -> ["Sữa", "tươi", "organic"])
                // $words = explode(' ', $keyword);

                // // Truy vấn sản phẩm dựa trên từ khóa tiếng Việt AI trả về
                // $products = Product::where(function ($query) use ($keyword, $words) {
                //     // Ưu tiên tìm chính xác cụm từ trước
                //     $query->where('name', 'LIKE', "%{$keyword}%")
                //         ->orWhere('description', 'LIKE', "%{$keyword}%");

                //     // Sau đó tìm theo từng từ đơn lẻ (tăng khả năng trúng)
                //     foreach ($words as $word) {
                //         if (strlen($word) > 2) { // Chỉ tìm các từ có nghĩa, bỏ qua từ quá ngắn
                //             $query->orWhere('name', 'LIKE', "%{$word}%");
                //         }
                //     }
                // })
                //     ->paginate(12)
                //     ->withQueryString();

                // return view('clients.pages.products-search', [
                //     'products' => $products,
                //     'keyword' => "Kết quả cho: " . $keyword
                // ]);

                return response()->json([
                    'status' => true,
                    'keyword' => $keyword
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể kết nối với dịch vụ AI.'], 500);
        }

        return response()->json(['error' => 'Có lỗi xảy ra.'], 500);
    }
}
