<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Barber;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
                           ->orderBy('sort_order')
                           ->orderBy('name')
                           ->take(6)
                           ->get();

        $barbers = Barber::where('is_active', true)
                         ->with('user')
                         ->take(4)
                         ->get();

        return view('home', compact('services', 'barbers'));
    }
}