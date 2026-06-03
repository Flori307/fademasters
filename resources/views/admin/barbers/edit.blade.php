@extends('layouts.app')

@section('title', 'Редактировать мастера')

@section('content')
<div class="bg-zinc-950 py-12 px-6">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold mb-10">Редактировать мастера: {{ $barber->nickname }}</h1>

        <form method="POST" action="{{ route('admin.barbers.update', $barber) }}" enctype="multipart/form-data" class="bg-zinc-900 rounded-3xl p-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">ФИО</label>
                    <input type="text" name="name" value="{{ $barber->user->name }}" required 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $barber->user->email }}" required 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Телефон</label>
                    <input type="tel" name="phone" value="{{ $barber->user->phone }}" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Никнейм</label>
                    <input type="text" name="nickname" value="{{ $barber->nickname }}" required 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Опыт (лет)</label>
                    <input type="number" name="experience_years" value="{{ $barber->experience_years }}" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <!-- Услуги мастера -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-3">Услуги мастера</label>
                    <div class="grid grid-cols-2 gap-3 bg-zinc-800 rounded-2xl p-4 border border-zinc-700 max-h-64 overflow-y-auto">
                        @foreach($services as $service)
                        <label class="flex items-center gap-3 cursor-pointer hover:bg-zinc-700/50 p-2 rounded-xl transition">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" 
                                   {{ $barber->services->contains($service->id) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-zinc-600 text-red-600 focus:ring-red-500">
                            <div class="flex-1">
                                <div class="font-medium text-sm">{{ $service->name }}</div>
                                <div class="text-xs text-zinc-500">{{ $service->duration_minutes }} мин • {{ number_format($service->price) }} ₽</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-zinc-500 mt-2">Отметьте услуги, которые предоставляет мастер</p>
                </div>

                <!-- Дни работы -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-3">Дни работы</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @php
                            $workingDays = $barber->working_days ?? [];
                        @endphp
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="monday" {{ in_array('monday', $workingDays) ? 'checked' : '' }} class="w-4 h-4 rounded border-zinc-600">
                            <span>Понедельник</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="tuesday" {{ in_array('tuesday', $workingDays) ? 'checked' : '' }} class="w-4 h-4 rounded border-zinc-600">
                            <span>Вторник</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="wednesday" {{ in_array('wednesday', $workingDays) ? 'checked' : '' }} class="w-4 h-4 rounded border-zinc-600">
                            <span>Среда</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="thursday" {{ in_array('thursday', $workingDays) ? 'checked' : '' }} class="w-4 h-4 rounded border-zinc-600">
                            <span>Четверг</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="friday" {{ in_array('friday', $workingDays) ? 'checked' : '' }} class="w-4 h-4 rounded border-zinc-600">
                            <span>Пятница</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="saturday" {{ in_array('saturday', $workingDays) ? 'checked' : '' }} class="w-4 h-4 rounded border-zinc-600">
                            <span>Суббота</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="sunday" {{ in_array('sunday', $workingDays) ? 'checked' : '' }} class="w-4 h-4 rounded border-zinc-600">
                            <span>Воскресенье</span>
                        </label>
                    </div>
                </div>

                <!-- График работы -->
                <div class="md:col-span-2 grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Начало работы</label>
                        <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($barber->start_time)->format('H:i') }}" required
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Конец работы</label>
                        <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($barber->end_time)->format('H:i') }}" required
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    </div>
                </div>

                <!-- Фото -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-3">Фото мастера</label>
                    @if($barber->photo)
                        <div class="mb-4">
                            @php
                                $photoUrl = null;
                                if(filter_var($barber->photo, FILTER_VALIDATE_URL)) {
                                    $photoUrl = $barber->photo;
                                } elseif(file_exists(public_path('storage/' . $barber->photo))) {
                                    $photoUrl = asset('storage/' . $barber->photo);
                                } elseif(file_exists(public_path($barber->photo))) {
                                    $photoUrl = asset($barber->photo);
                                }
                            @endphp
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" class="w-32 h-32 object-cover rounded-2xl" alt="">
                            @else
                                <div class="w-32 h-32 bg-zinc-800 rounded-2xl flex items-center justify-center text-4xl">👨‍🦰</div>
                            @endif
                        </div>
                    @endif
                    <input type="file" name="photo" accept="image/*" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    <p class="text-xs text-zinc-500 mt-2">Оставьте пустым, если не хотите менять фото</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Активен?</label>
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $barber->is_active ? 'checked' : '' }} class="w-4 h-4 rounded border-zinc-600">
                        <span>Мастер активен и может принимать записи</span>
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Описание / Биография</label>
                    <textarea name="description" rows="6" 
                              class="w-full bg-zinc-800 border border-zinc-700 rounded-3xl px-6 py-5">{{ $barber->description }}</textarea>
                </div>
            </div>

            <div class="mt-12 flex gap-4">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 py-5 rounded-2xl font-semibold transition">
                    Сохранить изменения
                </button>
                <a href="{{ route('admin.barbers.index') }}" 
                   class="flex-1 text-center border border-zinc-700 hover:bg-zinc-800 py-5 rounded-2xl font-semibold transition">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection