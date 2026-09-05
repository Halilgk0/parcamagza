<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PartController as AdminPartController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\EmailController as AdminEmailController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification Routes
Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.index');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Orders Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Profile specific routes
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{order}', [ProfileController::class, 'showOrder'])->name('profile.orders.show');
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::post('/profile/favorites/{part}', [ProfileController::class, 'toggleFavorite'])->name('profile.favorites.toggle');
    
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::put('/profile/addresses/{address}', [ProfileController::class, 'updateAddress'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{address}', [ProfileController::class, 'destroyAddress'])->name('profile.addresses.destroy');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{part}', [CartController::class, 'addItem'])->name('cart.add');
    Route::put('/cart/update/{cartItem}', [CartController::class, 'updateItem'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');
});

// Public Routes
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{slug}', [BrandController::class, 'show'])->name('brands.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/parts', [PartController::class, 'index'])->name('parts.index');
Route::get('/parts/search', [PartController::class, 'search'])->name('parts.search');
Route::get('/parts/{slug}', [PartController::class, 'show'])->name('parts.show');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/settings/update', [App\Http\Controllers\Admin\AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Parts Management
    Route::resource('parts', App\Http\Controllers\Admin\PartController::class);
    Route::get('parts/upload/bulk', [App\Http\Controllers\Admin\PartController::class, 'showBulkUploadForm'])->name('parts.bulk.form');
    Route::post('parts/upload/bulk', [App\Http\Controllers\Admin\PartController::class, 'processBulkUpload'])->name('parts.bulk.process');
    
    // Categories Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Brands Management
    Route::resource('brands', App\Http\Controllers\Admin\BrandController::class);

    // Models Management
    Route::resource('models', App\Http\Controllers\Admin\CarModelController::class);
    
    // Users Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // Orders Management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Footer Management
    Route::get('footer', [App\Http\Controllers\Admin\FooterController::class, 'index'])->name('footer.index');
    Route::get('footer/create', [App\Http\Controllers\Admin\FooterController::class, 'create'])->name('footer.create');
    Route::post('footer', [App\Http\Controllers\Admin\FooterController::class, 'store'])->name('footer.store');
    Route::get('footer/{footerLink}/edit', [App\Http\Controllers\Admin\FooterController::class, 'edit'])->name('footer.edit');
    Route::put('footer/{footerLink}', [App\Http\Controllers\Admin\FooterController::class, 'update'])->name('footer.update');
    Route::delete('footer/{footerLink}', [App\Http\Controllers\Admin\FooterController::class, 'destroy'])->name('footer.destroy');
    Route::post('footer/company-info', [App\Http\Controllers\Admin\FooterController::class, 'companyInfo'])->name('footer.company-info');
    
    // Reports
    Route::get('reports', [App\Http\Controllers\Admin\AdminController::class, 'reports'])->name('reports.index');
    
    // Email routes
    Route::get('/emails', [App\Http\Controllers\Admin\EmailController::class, 'index'])->name('emails.index');
    Route::post('/emails/send', [App\Http\Controllers\Admin\EmailController::class, 'send'])->name('emails.send');
    
    // Email Template routes
    Route::resource('email-templates', App\Http\Controllers\Admin\EmailTemplateController::class);
    Route::get('email-templates/{emailTemplate}/data', [App\Http\Controllers\Admin\EmailTemplateController::class, 'getData'])->name('email-templates.data');
    Route::get('email-templates-seed', [App\Http\Controllers\Admin\EmailTemplateController::class, 'seedSampleTemplates'])->name('email-templates-seed');
    
    // Banner Management
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
    Route::post('/dashboard/banner/store', [AdminBannerController::class, 'store'])->name('banners.store');
    Route::get('/dashboard/banner/{banner}/edit', [App\Http\Controllers\Admin\BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/dashboard/banner/{banner}', [App\Http\Controllers\Admin\BannerController::class, 'update'])->name('banners.update');
    Route::delete('/dashboard/banner/{banner}', [AdminBannerController::class, 'destroy'])->name('banners.destroy');
});
