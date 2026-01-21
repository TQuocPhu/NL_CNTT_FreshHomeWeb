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
}
