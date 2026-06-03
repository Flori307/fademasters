<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    /**
     * Показать всех мастеров
     */
    public function index()
    {
        $barbers = Barber::where('is_active', true)
                         ->with('user')
                         ->orderBy('nickname')
                         ->get();

        return view('barbers.index', compact('barbers'));
    }

    /**
     * Показать одного мастера
     */
    public function show(Barber $barber)
    {
        $barber->load(['user', 'services']);

        return view('barbers.show', compact('barber'));
    }
}