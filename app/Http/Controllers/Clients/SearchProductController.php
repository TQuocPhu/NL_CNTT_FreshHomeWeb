<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class SearchProductController extends Controller
{
    public function index(Request $request){

        $keyword = trim($request->input('keyword'));

        if (empty($keyword)) {
            return redirect()->back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
        }

        $products = Product::query()
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            })->paginate(12);

        $products->appends(['keyword' => $keyword]);

        return view('clients.pages.products-search', [
            'products' => $products,
            'keyword' => $keyword
        ]);
    }
}
