<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\MedicineController;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    
    Route::resource('doctors', DoctorController::class);
    Route::resource('clinics', ClinicController::class);
    Route::resource('medicines', MedicineController::class);
    
    Route::get('/consultations', [\App\Http\Controllers\Admin\ConsultationController::class, 'index'])->name('consultations.index');
    Route::post('/consultations/{consultation}/status', [\App\Http\Controllers\Admin\ConsultationController::class, 'updateStatus'])->name('consultations.updateStatus');
    Route::delete('/consultations/{consultation}', [\App\Http\Controllers\Admin\ConsultationController::class, 'destroy'])->name('consultations.destroy');
    
    Route::get('/orders', [\App\Http\Controllers\Admin\MedicineOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Admin\MedicineOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [\App\Http\Controllers\Admin\MedicineOrderController::class, 'destroy'])->name('orders.destroy');
});

// Client Routes
Route::middleware(['auth', 'client'])->prefix('client')->name('client.')->group(function () {
     Route::get('/dashboard', [DashboardController::class, 'client'])->name('dashboard');
    
    // Doctors
    Route::get('/doctors', [\App\Http\Controllers\Client\DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [\App\Http\Controllers\Client\DoctorController::class, 'show'])->name('doctors.show');
    
    // Clinics
    Route::get('/clinics', [\App\Http\Controllers\Client\ClinicController::class, 'index'])->name('clinics.index');
    Route::get('/clinics/{clinic}', [\App\Http\Controllers\Client\ClinicController::class, 'show'])->name('clinics.show');
    
    // Medicines
    Route::get('/medicines', [\App\Http\Controllers\Client\MedicineController::class, 'index'])->name('medicines.index');
    Route::get('/medicines/{medicine}', [\App\Http\Controllers\Client\MedicineController::class, 'show'])->name('medicines.show');
    
    // Cart
    Route::get('/cart', [\App\Http\Controllers\Client\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{medicine}', [\App\Http\Controllers\Client\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [\App\Http\Controllers\Client\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [\App\Http\Controllers\Client\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [\App\Http\Controllers\Client\CartController::class, 'clear'])->name('cart.clear');
    
    // Consultations
    Route::get('/consultations', [\App\Http\Controllers\Client\ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/create', [\App\Http\Controllers\Client\ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/consultations', [\App\Http\Controllers\Client\ConsultationController::class, 'store'])->name('consultations.store');
    Route::get('/consultations/{consultation}', [\App\Http\Controllers\Client\ConsultationController::class, 'show'])->name('consultations.show');
    Route::post('/consultations/{consultation}/cancel', [\App\Http\Controllers\Client\ConsultationController::class, 'cancel'])->name('consultations.cancel');
    
    // Medicine Orders
    Route::get('/orders', [\App\Http\Controllers\Client\MedicineOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [\App\Http\Controllers\Client\MedicineOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [\App\Http\Controllers\Client\MedicineOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [\App\Http\Controllers\Client\MedicineOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [\App\Http\Controllers\Client\MedicineOrderController::class, 'cancel'])->name('orders.cancel');

});

// Language Switcher
Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');