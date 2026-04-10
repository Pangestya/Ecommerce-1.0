<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
Use App\Http\Controllers\PembeliController;
Use App\Http\Controllers\PengawasController;
use App\Http\Controllers\Pengawas;
use App\Http\Controllers\Pengawas\UserController;
use App\Http\Controllers\Pengawas\ProfilePengawas;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Pengawas\AuditController;
use App\Http\Controllers\Pembeli\WishlistController;
use App\Http\Controllers\Pembeli\CartController;
use App\Http\Controllers\Pembeli\PembeliProfileController;
use App\Http\Controllers\Pembeli\AlamatController;
use App\Http\Controllers\Pembeli\RiwayatController;
use App\Http\Controllers\Pembeli\ReviewController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\FaqControllerAdmin;
use App\Http\Controllers\FaqController;

Route::get('/', function () {
    return view('welcome');
});

//Guest
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//ADMINISTRATOR
Route::middleware(['auth','verified', 'role:administrator'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('admin/products', ProductController::class)->names('admin.products');
    
    Route::patch('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('admin.products.toggle-status');

    Route::delete('/product-images/{id}', [ProductController::class, 'destroyImage'])->name('admin.products.delete-image');

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');

    Route::get('/categories/create', [CategoryController::class,'create' ])-> name('admin.categories.create');

    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');

    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/admin/profile', [ProfileAdminController::class, 'edit'])->name('admin.profile.edit');

    Route::patch('/admin/profile', [ProfileAdminController::class, 'update'])->name('admin.profile.update');

    Route::delete('/admin/profile', [ProfileAdminController::class, 'destroy'])->name('admin.profile.destroy');
    
    Route::put('/admin/password', [ProfileAdminController::class, 'updatePassword'])->name('admin.password.update');

    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    
    Route::patch('/admin/orders/{id}/process', [OrderController::class, 'process'])->name('admin.orders.process');
    
    Route::patch('/admin/orders/{id}/send', [OrderController::class, 'send'])->name('admin.orders.send');

    Route::resource('/admin/faqs', FaqControllerAdmin::class)->names('admin.faq');

    Route::get('/admin/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    
    Route::get('/admin/reports/print', [App\Http\Controllers\Admin\ReportController::class, 'print'])->name('admin.reports.print');
});

//PENGAWAS
Route::middleware(['auth','verified', 'role:pengawas'])->group(function () {

    Route::get('/pengawas/dashboard', [PengawasController::class, 'index'])->name('pengawas.dashboard');
    
    Route::resource('/pengawas/users', UserController::class)->names('pengawas.users');
    
    #Profile
    Route::get('/pengawas/profile', [ProfilePengawas::class, 'edit'])->name('pengawas.profile.edit');
    
    Route::patch('/pengawas/profile', [ProfilePengawas::class, 'update'])->name('pengawas.profile.update');
    
    Route::delete('/pengawas/profile', [ProfilePengawas::class, 'destroy'])->name('pengawas.profile.destroy');
    
    Route::put('/pengawas/password', [ProfilePengawas::class, 'updatePassword'])->name('pengawas.password.update');

    Route::get('/audit-logs', [AuditController::class, 'index'])->name('pengawas.audit.index');

    Route::get('/reports', [App\Http\Controllers\Pengawas\ReportController::class, 'index'])->name('reports.index');
    
    Route::get('/reports/print', [App\Http\Controllers\Pengawas\ReportController::class, 'print'])->name('pengawas.reports.print');
});

//PEMBELI
Route::middleware(['auth','verified', 'role:pembeli'])->group(function () {

    Route::get('/mojoreno-wonogiri', [PembeliController::class, 'index'])->name('pembeli.dashboard');

    Route::get('/product/{product}', [PembeliController::class, 'show'])->name('pembeli.product');

    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('pembeli.wishlist.toggle');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('pembeli.wishlist');

    Route::resource('/cart', CartController::class)->names('pembeli.cart');

    Route::patch('/alamat/{alamat}/set-primary', [AlamatController::class, 'setPrimary'])->name('pembeli.alamat.setPrimary');

    Route::resource('/alamat', AlamatController::class)->names('pembeli.alamat');

    Route::get('/pembeli/profile', [PembeliProfileController::class, 'edit'])->name('pembeli.profile.edit');

    Route::patch('/pembeli/profile', [PembeliProfileController::class, 'update'])->name('pembeli.profile.update');

    Route::put('/pembeli/profile/password', [PembeliProfileController::class, 'updatePassword'])->name('pembeli.profile.password');

    Route::get('/checkout', [App\Http\Controllers\Pembeli\CheckoutController::class, 'index'])->name('pembeli.checkout');
    
    Route::post('/checkout/ongkir', [App\Http\Controllers\Pembeli\CheckoutController::class, 'checkOngkir'])->name('pembeli.checkout.ongkir');
    
    Route::post('/checkout/process', [App\Http\Controllers\Pembeli\CheckoutController::class, 'process'])->name('pembeli.checkout.process');

    Route::get('/riwayat-pesanan', [RiwayatController::class, 'index'])->name('pembeli.riwayat.index');
    
    Route::get('/riwayat-pesanan/{id}', [RiwayatController::class, 'show'])->name('pembeli.riwayat.show');

    Route::patch('/riwayat-pesanan/{id}/complete', [RiwayatController::class, 'complete'])->name('pembeli.riwayat.complete');

    Route::get('/bantuan', [FaqController::class, 'index'])->name('pembeli.bantuan');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('pembeli.reviews.store');
});


// Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';