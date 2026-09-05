<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CarBrand;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $brands = CarBrand::where('is_active', true)
                ->with(['models' => function($query) {
                    $query->where('is_active', true);
                }])
                ->get();
                
            $categories = Category::where('is_active', true)
                ->whereNull('parent_id')
                ->get();
                
            $view->with(compact('brands', 'categories'));
        });
    }
}
