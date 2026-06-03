<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Страница записи
     */
    public function create(Request $request)
    {
        $services = Service::where('is_active', true)->get();

        $barbers = Barber::where('is_active', true)
            ->with('user')
            ->get();

        $selectedService = $request->get('service')
            ? Service::find($request->get('service'))
            : null;

        return view('appointments.create', compact(
            'services',
            'barbers',
            'selectedService'
        ));
    }

    /**
     * Создание записи
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id'       => 'required|exists:services,id',
            'barber_id'        => 'required|exists:barbers,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time'       => 'required|date_format:H:i',
            'notes'            => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($request->service_id);
        $barber  = Barber::findOrFail($request->barber_id);

        $date = Carbon::parse($request->appointment_date);

        // Полный datetime
        $startTime = Carbon::parse(
            $request->appointment_date . ' ' . $request->start_time
        );

        $endTime = $startTime->copy()->addMinutes(
            $service->duration_minutes
        );

        /**
         * Проверка: нельзя записаться в прошлое
         */
        if ($startTime->lt(now())) {
            return back()
                ->with('error', 'Нельзя записаться на прошедшее время')
                ->withInput();
        }

        /**
         * Проверка рабочего дня
         */
        $workingDays = $barber->working_days ?? [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday'
        ];

        $dayName = strtolower($date->format('l'));

        if (!in_array($dayName, $workingDays)) {
            return back()
                ->with('error', 'Мастер не работает в этот день')
                ->withInput();
        }

        /**
         * Рабочее время мастера
         */
        $barberStart = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->appointment_date . ' ' . Carbon::parse($barber->start_time)->format('H:i')
        );

        $barberEnd = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->appointment_date . ' ' . Carbon::parse($barber->end_time)->format('H:i')
        );

        if ($startTime < $barberStart || $endTime > $barberEnd) {
            return back()
                ->with('error', 'Выбранное время выходит за пределы рабочего дня мастера')
                ->withInput();
        }

        /**
         * Проверка пересечения записей
         */
        $existingAppointment = Appointment::where('barber_id', $barber->id)
            ->whereDate('appointment_date', $date->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($startTime, $endTime) {

                $query->where(function ($q) use ($startTime, $endTime) {

                    $q->where('start_time', '<', $endTime->format('H:i'))
                      ->where('end_time', '>', $startTime->format('H:i'));

                });

            })
            ->exists();

        if ($existingAppointment) {
            return back()
                ->with('error', 'Это время уже занято')
                ->withInput();
        }

        /**
         * Проверка услуги мастера
         */
        if (
            !$barber->services()
                ->where('service_id', $service->id)
                ->exists()
        ) {
            return back()
                ->with('error', 'Данный мастер не предоставляет эту услугу')
                ->withInput();
        }

        /**
         * Создание записи
         */
        Appointment::create([
            'user_id'          => Auth::id(),
            'barber_id'        => $barber->id,
            'service_id'       => $service->id,
            'appointment_date' => $date->format('Y-m-d'),
            'start_time'       => $startTime->format('H:i'),
            'end_time'         => $endTime->format('H:i'),
            'status'           => 'pending',
            'notes'            => $request->notes,
        ]);

        return redirect()
            ->route('profile.appointments')
            ->with('success', 'Запись успешно создана');
    }

    /**
     * Мои записи
     */
    public function myAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->with([
                'service',
                'barber.user'
            ])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        return view('appointments.my', compact('appointments'));
    }

    /**
     * Свободные слоты
     */
    /**
 * Свободные слоты
 */
public function getAvailableSlots(Request $request)
{
    $request->validate([
        'barber_id'  => 'required|exists:barbers,id',
        'service_id' => 'required|exists:services,id',
        'date'       => 'required|date|after_or_equal:today',
    ]);

    $barber = Barber::findOrFail($request->barber_id);
    $service = Service::findOrFail($request->service_id);
    $selectedDate = $request->date;
    
    $now = now();
    $today = $now->format('Y-m-d');
    $currentHour = (int)$now->format('H');
    $currentMinute = (int)$now->format('i');
    
    // Проверка рабочего дня
    $workingDays = $barber->working_days ?? ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    $dayName = strtolower(date('l', strtotime($selectedDate)));
    
    if (!in_array($dayName, $workingDays)) {
        return response()->json([
            'slots' => [], 
            'message' => 'Мастер не работает в этот день'
        ]);
    }
    
    // ПОЛУЧАЕМ ВСЕ ЗАНЯТЫЕ СЛОТЫ С УЧЁТОМ ДЛИТЕЛЬНОСТИ
    $bookedAppointments = Appointment::where('barber_id', $barber->id)
        ->where('appointment_date', $selectedDate)
        ->whereIn('status', ['pending', 'confirmed'])
        ->get(['start_time', 'end_time']);
    
    // Время работы мастера
    $workStartHour = (int)date('H', strtotime($barber->start_time));
    $workStartMinute = (int)date('i', strtotime($barber->start_time));
    $workEndHour = (int)date('H', strtotime($barber->end_time));
    $workEndMinute = (int)date('i', strtotime($barber->end_time));
    
    $serviceDuration = $service->duration_minutes;
    $availableSlots = [];
    
    // Генерируем слоты с шагом 30 минут
    for ($hour = $workStartHour; $hour <= $workEndHour; $hour++) {
        // Определяем минуты для текущего часа
        $minutesArray = ($hour == $workEndHour) ? [0] : [0, 30];
        
        foreach ($minutesArray as $minute) {
            // Пропускаем время до начала работы
            if ($hour == $workStartHour && $minute < $workStartMinute) {
                continue;
            }
            
            // Пропускаем время после окончания работы
            if ($hour == $workEndHour && $minute > $workEndMinute) {
                continue;
            }
            
            $slotStart = sprintf('%02d:%02d', $hour, $minute);
            
            // Вычисляем время окончания слота с учётом длительности услуги
            $slotStartTimestamp = strtotime($slotStart);
            $slotEndTimestamp = $slotStartTimestamp + ($serviceDuration * 60);
            $slotEnd = date('H:i', $slotEndTimestamp);
            
            // Проверка: не пересекается ли слот с существующими записями
            $isBooked = false;
            foreach ($bookedAppointments as $booked) {
                $bookedStart = $booked->start_time;
                $bookedEnd = $booked->end_time;
                
                // Проверка пересечения интервалов
                if ($slotStart < $bookedEnd && $slotEnd > $bookedStart) {
                    $isBooked = true;
                    break;
                }
            }
            
            if ($isBooked) {
                continue;
            }
            
            // Проверка для сегодняшней даты: пропускаем прошедшие слоты
            if ($selectedDate == $today) {
                if ($hour < $currentHour) {
                    continue;
                }
                if ($hour == $currentHour && $minute <= $currentMinute) {
                    continue;
                }
            }
            
            $availableSlots[] = $slotStart;
        }
    }
    
    return response()->json([
        'slots' => $availableSlots,
        'duration' => $serviceDuration
    ]);
}

    /**
     * Отмена записи
     */
    public function cancel(Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        if (
            !in_array($appointment->status, [
                'pending',
                'confirmed'
            ])
        ) {
            return back()
                ->with('error', 'Эту запись уже нельзя отменить');
        }

        $appointment->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_reason' => 'Отменено клиентом',
        ]);

        return back()
            ->with('success', 'Запись успешно отменена');
    }

    /**
     * Услуги мастера
     */
    public function getBarberServices(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
        ]);

        $barber = Barber::findOrFail($request->barber_id);

        $services = $barber->services()
            ->pluck('services.id');

        return response()->json([
            'services' => $services
        ]);
    }
}