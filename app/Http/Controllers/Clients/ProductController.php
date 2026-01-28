<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index() {
        $categories = Category::with('products')->get();

        $products = Product::with('firstImage')->where('status', 'in_stock')->paginate(9);

        return view('clients.pages.products', compact('categories', 'products'));
    }
    
    public function filter(Request $request) {
        $query = Product::query()->where('status', 'in_stock');

        //lọc theo category_id
        if($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        //Lọc theo khoảng giá
        if($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        //Bộ lọc sắp xếp
        if($request->has('sort_by')) {
            switch($request->sort_by) {
                case 'latest':
                    $query->orderByDesc('created_at');
                    break;
                case 'price-asc': 
                    $query->orderBy('price');
                    break;
                case 'price-desc': 
                    $query->orderByDesc('price');
                    break;
                default: 
                    $query->orderByDesc('id');
                    break;
            }
        }
        
        //Phân trang
        $products = $query->paginate(9);

        /** @var \Illuminate\View\View $links */
        $links = $products->links('clients.components.pagination.pagination-custom');

        return response()->json([
            'status' => 'success',
            'products' => view('clients.components.products-grid', compact('products'))->render(),
            'pagination' => $links->render(),
        ]);
    }

    public function detail($slug) {
        $product = Product::with('category', 'images', 'reviews.user')->where('slug', $slug)->firstOrFail();
        
        //Lấy sản phẩm liên quan (tương tự category)
        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->limit(6)->get();
        return view('clients.pages.product-detail', compact('product', 'relatedProducts'));
    }
}
