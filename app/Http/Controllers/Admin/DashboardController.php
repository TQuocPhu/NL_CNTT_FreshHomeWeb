<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $year = $request->input('year', date('Y'));

        //Thống kê tổng quát
        $totalUsers = User::where('role_id', 3)->count();
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        $totalFailedPayments = Payment::where('status', 'failed')->count();
        $totalCanceledOrders = Order::where('status', 'canceled')->count();

        // Biểu đồ donut (danh mục sản phẩm)
        $categories = Category::withCount('products')->get();
        $chartLabels = $categories->pluck('name');
        $chartData = $categories->pluck('products_count');

        // Biểu đồ Bar (Thống kê đơn hàng)
        $orderStats = Order::selectRaw('
                MONTH(created_at) as month,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as success,
                SUM(CASE WHEN status = "canceled" THEN 1 ELSE 0 END) as canceled
            ')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        //Line Chart (Thống kê doanh thu)
        $revenueData = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month');

        //Chuẩn hóa dữ liệu cho bar và line chart
        $months = range(1, 12);
        $orderSuccess = [];
        $orderCanceled = [];
        $revenues = [];

        foreach ($months as $month) {
            $orderSuccess[] = $orderStats[$month]->success ?? 0;
            $orderCanceled[] = $orderStats[$month]->canceled ?? 0;
            $revenues[] = (float)($revenueData[$month] ?? 0);
        }

        // Top 5 sản phẩm bán chạy
        $topSellingProducts = Product::with(['category'])
            ->withCount(['orderItems as total_sold' => function ($query) {
                $query->selectRaw(DB::raw('COALESCE(SUM(quantity), 0)'));
            }])
            ->withSum(['orderItems as actual_revenue' => function ($query) {
                $query->selectRaw(DB::raw('COALESCE(SUM(quantity * price), 0)'));
            }], 'price')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();


        // Đơn hàng nổi bật
        $ratingOrders = Order::with('shippingAddress', 'user', 'payment')
            ->whereIn('status', ['processing', 'completed'])
            ->orderByDesc('total_price')
            ->limit(3)
            ->get();

        // Khách hàng mới
        $newUsers = User::where('role_id', 3)->latest()->take(3)->get();

        return view('admin.pages.dashboard', compact(
            'year',
            'totalUsers',
            'totalCategories',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'totalFailedPayments',
            'totalCanceledOrders',
            'chartLabels',
            'chartData',
            'orderSuccess',
            'orderCanceled',
            'revenues',
            'topSellingProducts',
            'ratingOrders',
            'newUsers'
        ));
    }
}
