<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;

class PageController extends Controller
{
    public function about()
    {
        // Получаем всех активных мастеров
        $barbers = Barber::where('is_active', true)
                        ->orderBy('experience_years', 'desc')
                        ->get();
        
        // Статистика
        $totalClients = User::role('client')->count();
        $totalAppointments = Appointment::where('status', 'completed')->count();
        $avgExperience = Barber::where('is_active', true)->avg('experience_years') ?? 8;
        
        return view('pages.about', compact('barbers', 'totalClients', 'totalAppointments', 'avgExperience'));
    }
}