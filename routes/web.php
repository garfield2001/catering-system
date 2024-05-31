<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CateringController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    // Redirect to admin login for the root and /admin routes
    Route::redirect('/', '/admin/login');
    Route::redirect('/admin', '/admin/login');

    // Authentication routes
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login.show');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('login');

    Route::get('/admin/register', [AuthController::class, 'showRegisterForm'])->name('register.show');
    Route::post('/admin/register', [AuthController::class, 'register'])->name('register');

    // Routes protected by auth middleware
    Route::middleware('auth:admin_users')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Category routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Package routes
        Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
        Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
        Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
        Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');

        // Dish routes
        Route::get('/dishes', [DishController::class, 'index'])->name('dishes.index');
        Route::post('/dishes', [DishController::class, 'store'])->name('dishes.store');
        Route::put('/dishes/{dish}', [DishController::class, 'update'])->name('dishes.update');
        Route::delete('/dishes/{dish}', [DishController::class, 'destroy'])->name('dishes.destroy');

        // Logout route
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


        // Test route
        Route::get('/test', [DashboardController::class, 'test'])->name('test.index');
    });
});
