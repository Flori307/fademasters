<?php

namespace App\Http\Controllers\Barber;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $barber = Auth::user()->barber;

        if (!$barber) {
            abort(403, 'Вы не являетесь барбером');
        }

        // Записи на сегодня
        $todayAppointments = Appointment::where('barber_id', $barber->id)
            ->where('appointment_date', today())
            ->with(['service', 'user'])
            ->orderBy('start_time')
            ->get();

        // Будущие записи (на ближайшие 7 дней)
        $upcomingAppointments = Appointment::where('barber_id', $barber->id)
            ->where('appointment_date', '>', today())
            ->where('appointment_date', '<=', now()->addDays(7))
            ->with(['service', 'user'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();

        // Статистика на сегодня
        $totalToday = $todayAppointments->count();
        $confirmedToday = $todayAppointments->where('status', 'confirmed')->count();
        $pendingToday = $todayAppointments->where('status', 'pending')->count();
        $completedToday = $todayAppointments->where('status', 'completed')->count();

        return view('barber.dashboard', compact(
            'todayAppointments', 
            'upcomingAppointments', 
            'barber',
            'totalToday',
            'confirmedToday',
            'pendingToday',
            'completedToday'
        ));
    }

    public function updateStatus(Appointment $appointment, Request $request)
    {
        $barber = Auth::user()->barber;

        if ($appointment->barber_id !== $barber->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled,no_show'
        ]);

        $appointment->update([
            'status' => $request->status,
            'cancelled_at' => in_array($request->status, ['cancelled', 'no_show']) ? now() : null,
        ]);

        return back()->with('success', 'Статус записи успешно обновлён');
    }
}