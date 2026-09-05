<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\Category;
use App\Models\CarBrand;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_parts' => Part::count(),
            'total_categories' => Category::count(),
            'total_brands' => CarBrand::count(),
            'total_users' => User::count(),
        ];
        
        // Make sure the Banner model exists and is properly loaded
        try {
            $banners = Banner::orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            // If there's an error, provide an empty collection
            $banners = collect([]);
        }
        
        // Get site settings
        $settings = [
            'site_name' => config('app.name', 'Parca Magaza'),
            'contact_email' => 'info@parcamagaza.com',
            'notification_email' => 'bildirim@parcamagaza.com',
            'site_description' => 'Otomotiv parçaları için profesyonel çözüm'
        ];
        
        return view('admin.dashboard_new', compact('stats', 'settings'));
    }
} 