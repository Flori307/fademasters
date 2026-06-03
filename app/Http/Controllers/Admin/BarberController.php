<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Service;

class BarberController extends Controller
{
    public function index()
    {
        $barbers = Barber::with('user')->get();
        return view('admin.barbers.index', compact('barbers'));
    }

    public function create()
{
    $services = Service::where('is_active', true)->orderBy('name')->get();
    return view('admin.barbers.create', compact('services'));
}

    public function store(Request $request)
{
    $request->validate([
        'name'              => 'required|string|max:255',
        'email'             => 'required|email|unique:users,email',
        'phone'             => 'nullable|string|max:20|unique:users,phone',
        'nickname'          => 'required|string|max:100',
        'specialization'    => 'nullable|string',
        'experience_years'  => 'nullable|integer|min:0',
        'description'       => 'nullable|string',
        'start_time'        => 'required',
        'end_time'          => 'required',
        'photo'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    ]);

    // Создаём пользователя
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'phone'    => $request->phone,
        'password' => bcrypt('password123'),
    ]);

    $user->assignRole('barber');

    // Создаём профиль барбера
    $barber = Barber::create([
        'user_id'                => $user->id,
        'nickname'               => $request->nickname,
        'specialization'         => $request->specialization,
        'experience_years'       => $request->experience_years,
        'description'            => $request->description,
        'start_time'             => $request->start_time,
        'end_time'               => $request->end_time,
        'slot_duration_minutes'  => 30, // фиксированное значение, не влияет на длительность услуги
        'is_active'              => true,
    ]);

    // Загрузка фото
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('barbers', 'public');
        $barber->update(['photo' => $path]);
    }

    // Привязываем выбранные услуги
    if ($request->has('services')) {
        $barber->services()->sync($request->services);
    }

    return redirect()->route('admin.barbers.index')
                     ->with('success', 'Мастер успешно создан. Временный пароль: password123');
}

    public function edit(Barber $barber)
{
    $services = Service::where('is_active', true)->orderBy('name')->get();
    return view('admin.barbers.edit', compact('barber', 'services'));
}

    public function update(Request $request, Barber $barber)
{
    $request->validate([
        'name'              => 'required|string|max:255',
        'email'             => 'required|email|unique:users,email,' . $barber->user_id,
        'phone'             => 'nullable|string|max:20|unique:users,phone,' . $barber->user_id,
        'nickname'          => 'required|string|max:100',
        'specialization'    => 'nullable|string',
        'experience_years'  => 'nullable|integer|min:0',
        'description'       => 'nullable|string',
        'start_time'        => 'required',
        'end_time'          => 'required',
        'is_active'         => 'boolean',
        'photo'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    ]);

    $barber->user->update([
        'name'  => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    $barber->update([
        'nickname'               => $request->nickname,
        'specialization'         => $request->specialization,
        'experience_years'       => $request->experience_years,
        'description'            => $request->description,
        'start_time'             => $request->start_time,
        'end_time'               => $request->end_time,
        'is_active'              => $request->boolean('is_active'),
    ]);

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('barbers', 'public');
        $barber->update(['photo' => $path]);
    }

    // Привязываем выбранные услуги
    if ($request->has('services')) {
        $barber->services()->sync($request->services);
    }

    return redirect()->route('admin.barbers.index')
                     ->with('success', 'Мастер успешно обновлён');
}

    public function destroy(Barber $barber)
    {
        $barber->user->delete(); // удаляем и пользователя
        return redirect()->route('admin.barbers.index')
                         ->with('success', 'Мастер удалён');
    }
}