<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $categories = Category::with('products.firstImage')->get();
        
        // Sử dụng groupBy + selectRaw
        // $bestSellingProducts = Product::select('products.*')
        //     ->join('order_items', 'products.id', '=', 'order_items.product_id')
        //     ->selectRaw('SUM(order_items.quantity) as total_sold')
        //     ->groupBy([
        //         'products.id',
        //         'products.name',
        //         'products.slug',
        //         'products.category_id',
        //         'products.description',
        //         'products.price',
        //         'products.stock',
        //         'products.status',
        //         'products.unit',
        //         'products.created_at',
        //         'products.updated_at'
        //     ])->orderByDesc('total_sold')
        //     ->take(8)
        //     ->get();

        //Sử dụng withSum của Laravel
        $bestSellingProducts = Product::with('firstImage')
            ->withSum('orderItems as total_sold', 'quantity')
            ->having('total_sold', '>' , 0)
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();

        return view('clients.pages.home', compact('categories', 'bestSellingProducts'));
    }
}
