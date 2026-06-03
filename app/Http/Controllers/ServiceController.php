<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
                           ->orderBy('sort_order')
                           ->orderBy('name')
                           ->get();

        return view('services.index', compact('services'));
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }
}