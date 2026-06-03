<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Barber;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['user', 'barber.user', 'service'])
                            ->orderBy('appointment_date', 'desc')
                            ->orderBy('start_time', 'desc');

        // По умолчанию НЕ показываем завершённые записи
        if (!$request->filled('status')) {
            $query->where('status', '!=', 'completed');
        }

        // Фильтры
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('appointment_date', '<=', $request->date_to);
        }

        if ($request->filled('barber_id')) {
            $query->where('barber_id', $request->barber_id);
        }

        $appointments = $query->paginate(20);

        $barbers = Barber::where('is_active', true)->get();

        return view('admin.appointments.index', compact('appointments', 'barbers'));
    }

    public function updateStatus(Appointment $appointment, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $appointment->update([
            'status' => $request->status,
            'cancelled_at' => $request->status == 'cancelled' ? now() : null,
        ]);

        return back()->with('success', 'Статус записи обновлён');
    }
}