<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\User;
use App\Models\Category;
use App\Models\CarBrand;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_parts' => Part::count(),
            'active_parts' => Part::where('is_active', true)->count(),
            'out_of_stock_parts' => Part::where('stock_quantity', 0)->count(),
            'total_categories' => Category::count(),
            'total_brands' => CarBrand::count(),
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'admin_users' => User::where('is_admin', true)->count(),
        ];

        $topCategories = Category::withCount('parts')
            ->orderBy('parts_count', 'desc')
            ->take(5)
            ->get();

        $topBrands = CarBrand::withCount('models')
            ->orderBy('models_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact('stats', 'topCategories', 'topBrands'));
    }

    public function sales()
    {
        // Bu metod sipariş sistemi eklendiğinde güncellenecek
        return view('admin.reports.sales');
    }

    public function users()
    {
        $userStats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admin' => User::where('is_admin', true)->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
        ];

        $recentUsers = User::latest()
            ->take(10)
            ->get();

        return view('admin.reports.users', compact('userStats', 'recentUsers'));
    }
} 