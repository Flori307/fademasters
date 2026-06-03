@extends('layouts.app')

@section('title', 'Добавить мастера')

@section('content')
<div class="bg-zinc-950 py-12 px-6">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold mb-10">Добавить нового мастера</h1>

        <form method="POST" action="{{ route('admin.barbers.store') }}" enctype="multipart/form-data" class="bg-zinc-900 rounded-3xl p-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Основная информация -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">ФИО (полное имя)</label>
                    <input type="text" name="name" required 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Email</label>
                    <input type="email" name="email" required 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Телефон</label>
                    <input type="tel" name="phone" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Никнейм / Отображаемое имя</label>
                    <input type="text" name="nickname" required 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Опыт (лет)</label>
                    <input type="number" name="experience_years" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <!-- Фото -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-3">Фото мастера</label>
                    <input type="file" name="photo" accept="image/*" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <!-- Услуги мастера (выбор из списка) -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-3">Услуги мастера</label>
                    <div class="grid grid-cols-2 gap-3 bg-zinc-800 rounded-2xl p-4 border border-zinc-700">
                        @foreach($services as $service)
                        <label class="flex items-center gap-3 cursor-pointer hover:bg-zinc-700/50 p-2 rounded-xl transition">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" 
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

                <!-- График работы -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-3">Рабочие дни</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="monday" checked class="w-4 h-4 rounded border-zinc-600">
                            <span>Понедельник</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="tuesday" checked class="w-4 h-4 rounded border-zinc-600">
                            <span>Вторник</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="wednesday" checked class="w-4 h-4 rounded border-zinc-600">
                            <span>Среда</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="thursday" checked class="w-4 h-4 rounded border-zinc-600">
                            <span>Четверг</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="friday" checked class="w-4 h-4 rounded border-zinc-600">
                            <span>Пятница</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="saturday" class="w-4 h-4 rounded border-zinc-600">
                            <span>Суббота</span>
                        </label>
                        <label class="flex items-center gap-3 bg-zinc-800 rounded-2xl px-4 py-3 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="sunday" class="w-4 h-4 rounded border-zinc-600">
                            <span>Воскресенье</span>
                        </label>
                    </div>
                </div>

                <div class="md:col-span-2 grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Начало работы</label>
                        <input type="time" name="start_time" value="10:00" required
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Конец работы</label>
                        <input type="time" name="end_time" value="20:00" required
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    </div>
                </div>

                <!-- Описание -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Описание / Биография</label>
                    <textarea name="description" rows="5" 
                              class="w-full bg-zinc-800 border border-zinc-700 rounded-3xl px-6 py-5"></textarea>
                </div>
            </div>

            <div class="mt-12">
                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 py-5 rounded-2xl font-semibold text-lg">
                    Создать мастера
                </button>
            </div>
        </form>
    </div>
</div>
@endsection