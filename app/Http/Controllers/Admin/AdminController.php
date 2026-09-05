<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\Category;
use App\Models\CarBrand;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_parts' => Part::count(),
            'total_categories' => Category::count(),
            'total_brands' => CarBrand::count(),
            'total_users' => User::count(),
        ];

        $settings = [
            'site_name' => config('app.name'),
            'site_description' => config('app.description'),
            'contact_email' => config('mail.from.address'),
            'notification_email' => config('site.notification_email'),
        ];
        
        // Get home page banners for the dashboard
        $banners = Banner::where('section', 'home_banner')
            ->orderBy('order')
            ->get();

        return view('admin.dashboard', compact('stats', 'settings', 'banners'));
    }

    public function updateSettings(Request $request)
    {
        // If it's a GET request, redirect to dashboard
        if ($request->isMethod('get')) {
            return redirect()->route('admin.dashboard');
        }
        
        try {
            $validated = $request->validate([
                'site_name' => 'required|string|max:255',
                'site_description' => 'nullable|string',
                'contact_email' => 'required|email',
                'notification_email' => 'nullable|email',
                'site_logo' => 'nullable|image|max:2048',
            ]);

            // Önce .env dosyasını güncelleyelim
            $envPath = base_path('.env');
            if (file_exists($envPath)) {
                $envContent = file_get_contents($envPath);
                
                // APP_NAME güncellemesi
                if (strpos($envContent, 'APP_NAME=') !== false) {
                    $envContent = preg_replace(
                        '/APP_NAME=.*/',
                        'APP_NAME="' . $validated['site_name'] . '"',
                        $envContent
                    );
                } else {
                    $envContent .= "\nAPP_NAME=\"" . $validated['site_name'] . "\"";
                }
                
                // MAIL_FROM_ADDRESS güncellemesi
                if (strpos($envContent, 'MAIL_FROM_ADDRESS=') !== false) {
                    $envContent = preg_replace(
                        '/MAIL_FROM_ADDRESS=.*/',
                        'MAIL_FROM_ADDRESS="' . $validated['contact_email'] . '"',
                        $envContent
                    );
                } else {
                    $envContent .= "\nMAIL_FROM_ADDRESS=\"" . $validated['contact_email'] . "\"";
                }
                
                file_put_contents($envPath, $envContent);
            }

            // Handle logo upload if present
            if ($request->hasFile('site_logo')) {
                $logo = $request->file('site_logo');
                $logoName = 'logo.' . $logo->getClientOriginalExtension();
                
                // Mevcut logoları temizleyelim
                $logoPath = public_path('images/logo.png');
                if (file_exists($logoPath)) {
                    @unlink($logoPath);
                }
                
                $logoPath = public_path('images/logo.jpg');
                if (file_exists($logoPath)) {
                    @unlink($logoPath);
                }
                
                // Yeni logoyu kaydedelim
                $logo->move(public_path('images'), $logoName);
            }

            // Site açıklaması için config dosyasını oluşturalım
            if (!file_exists(config_path('site.php'))) {
                // Dizin yoksa oluşturalım
                if (!file_exists(config_path())) {
                    mkdir(config_path(), 0755, true);
                }
            }
            
            $configContent = "<?php\n\nreturn " . var_export([
                'description' => $validated['site_description'],
                'notification_email' => $validated['notification_email'] ?? null,
            ], true) . ";\n";
            file_put_contents(config_path('site.php'), $configContent);

            // Geçerli istekte yapılandırma güncellemeleri
            config(['app.name' => $validated['site_name']]);
            config(['app.description' => $validated['site_description']]);
            config(['mail.from.address' => $validated['contact_email']]);
            config(['site.notification_email' => $validated['notification_email'] ?? null]);
            
            // Önbelleği temizle
            try {
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                Artisan::call('route:clear');
                Cache::flush();
            } catch (\Exception $e) {
                // Önbellek temizleme hatası olursa devam et
            }

            // Başarılı mesajıyla dashboard'a yönlendir
            return redirect()->route('admin.dashboard')
                ->with('success', 'Site ayarları başarıyla güncellendi!');
        } catch (\Exception $e) {
            // Hata durumunda bilgi mesajıyla dashboard'a yönlendir
            return redirect()->route('admin.dashboard')
                ->with('error', 'Ayarlar güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    private function updateEnvironmentFile($data)
    {
        // Not needed anymore, we're directly updating the .env file
    }

    public function reports()
    {
        return view('admin.reports');
    }
} 