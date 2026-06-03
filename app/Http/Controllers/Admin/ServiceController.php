<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5|max:300',
            'price'            => 'required|numeric|min:0',
            'category'         => 'nullable|string|max:100',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order'       => 'nullable|integer',
        ]);

        $service = Service::create([
            'name'             => $request->name,
            'slug'             => Str::slug($request->name),
            'description'      => $request->description,
            'duration_minutes' => $request->duration_minutes,
            'price'            => $request->price,
            'category'         => $request->category,
            'sort_order'       => $request->sort_order ?? 0,
            'is_active'        => true,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $service->update(['image' => $path]);
        }

        return redirect()->route('admin.services.index')
                         ->with('success', 'Услуга успешно создана');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5|max:300',
            'price'            => 'required|numeric|min:0',
            'category'         => 'nullable|string|max:100',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order'       => 'nullable|integer',
            'is_active'        => 'boolean',
        ]);

        $service->update([
            'name'             => $request->name,
            'slug'             => Str::slug($request->name),
            'description'      => $request->description,
            'duration_minutes' => $request->duration_minutes,
            'price'            => $request->price,
            'category'         => $request->category,
            'sort_order'       => $request->sort_order ?? 0,
            'is_active'        => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $service->update(['image' => $path]);
        }

        return redirect()->route('admin.services.index')
                         ->with('success', 'Услуга успешно обновлена');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
                         ->with('success', 'Услуга удалена');
    }
}