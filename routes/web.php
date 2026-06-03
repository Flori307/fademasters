<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// ====================== Публичная часть сайта ======================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/barbers', [BarberController::class, 'index'])->name('barbers.index');
Route::get('/barbers/{barber}', [BarberController::class, 'show'])->name('barbers.show');

// Онлайн-запись
Route::get('/booking', [AppointmentController::class, 'create'])->name('booking.create');
Route::post('/booking', [AppointmentController::class, 'store'])->name('booking.store');
Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
Route::post('/booking/available-slots', [AppointmentController::class, 'getAvailableSlots'])
     ->name('booking.available-slots');
Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
     ->name('appointments.cancel')
     ->middleware('auth');

Route::post('/barber/services', [AppointmentController::class, 'getBarberServices'])->name('barber.services');

// Контакты и статические страницы
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contacts', fn() => view('pages.contacts'))->name('contacts');

// ====================== Админ-панель ======================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

    // Услуги
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);

    // Мастера
    Route::resource('barbers', \App\Http\Controllers\Admin\BarberController::class);

    // Записи
    Route::get('appointments', [\App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('appointments/{appointment}/status', [\App\Http\Controllers\Admin\AppointmentController::class, 'updateStatus'])->name('appointments.status');

    // ========== ОТЗЫВЫ (ДОБАВИТЬ ЭТОТ БЛОК) ==========
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// ====================== Панель Барбера ======================
Route::prefix('barber')->middleware(['auth', 'role:barber'])->name('barber.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Barber\DashboardController::class, 'index'])
         ->name('dashboard');

    Route::patch('/appointments/{appointment}/status', [\App\Http\Controllers\Barber\DashboardController::class, 'updateStatus'])
         ->name('appointments.status');
});

// Личный кабинет клиента
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/my-appointments', [\App\Http\Controllers\ProfileController::class, 'myAppointments'])->name('profile.appointments');
});

// Отзывы
Route::middleware('auth')->group(function () {
    Route::get('/barbers/{barber}/review', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/barbers/{barber}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Авторизация (Breeze уже установлен)
require __DIR__.'/auth.php';