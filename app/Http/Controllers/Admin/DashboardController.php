<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Service;
use App\Models\User;
use App\Models\Review;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'total_appointments' => Appointment::count(),
            'today_appointments' => Appointment::where('appointment_date', today())->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'total_barbers' => Barber::where('is_active', true)->count(),
            'total_services' => Service::where('is_active', true)->count(),
            'total_clients' => User::role('client')->count(),
        ];

        $todayAppointments = Appointment::where('appointment_date', today())
            ->with(['service', 'barber.user', 'user'])
            ->orderBy('start_time')
            ->get();

        // Количество отзывов на модерации
        $pendingReviews = Review::where('is_approved', false)->count();

        return view('admin.dashboard', compact('stats', 'todayAppointments', 'pendingReviews'));
    }
}