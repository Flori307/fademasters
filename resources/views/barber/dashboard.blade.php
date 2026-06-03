@extends('layouts.app')

@section('title', 'Панель барбера — ' . (auth()->user()->barber->nickname ?? auth()->user()->name))

@section('content')
<div class="bg-zinc-950 py-10 px-6 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <div class="mb-12">
            <h1 class="text-4xl font-bold">
                Привет, {{ auth()->user()->barber->nickname ?? auth()->user()->name }}!
            </h1>
            <p class="text-zinc-400">Панель управления записями • {{ now()->format('d.m.Y') }}</p>
        </div>

        <!-- Статистика сегодня -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-zinc-900 p-6 rounded-3xl">
                <p class="text-zinc-400 text-sm">Всего сегодня</p>
                <p class="text-5xl font-bold mt-2">{{ $totalToday }}</p>
            </div>
            <div class="bg-zinc-900 p-6 rounded-3xl">
                <p class="text-zinc-400 text-sm">Ожидает</p>
                <p class="text-5xl font-bold mt-2 text-amber-500">{{ $pendingToday }}</p>
            </div>
            <div class="bg-zinc-900 p-6 rounded-3xl">
                <p class="text-zinc-400 text-sm">Подтверждено</p>
                <p class="text-5xl font-bold mt-2 text-green-500">{{ $confirmedToday }}</p>
            </div>
            <div class="bg-zinc-900 p-6 rounded-3xl">
                <p class="text-zinc-400 text-sm">Завершено</p>
                <p class="text-5xl font-bold mt-2 text-blue-500">{{ $completedToday }}</p>
            </div>
        </div>

        <!-- Записи на сегодня -->
        <h2 class="text-2xl font-semibold mb-6">Записи на сегодня</h2>

        @if($todayAppointments->isEmpty())
            <div class="bg-zinc-900 rounded-3xl p-20 text-center text-zinc-400">
                <p class="text-xl">Сегодня у вас нет записей</p>
            </div>
        @else
            <div class="space-y-5">
                @foreach($todayAppointments as $appointment)
                <div class="bg-zinc-900 rounded-3xl p-7 flex flex-col md:flex-row gap-6 items-center">
                    
                    <div class="w-28 text-center">
                        <div class="text-4xl font-mono font-bold text-white">
                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}
                        </div>
                        <div class="text-xs text-zinc-500 mt-1">начало</div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-lg truncate">{{ $appointment->user?->name ?? 'Неизвестный клиент' }}</div>
                        <div class="text-zinc-400">{{ $appointment->service?->name ?? 'Услуга не указана' }}</div>
                        @if($appointment->notes)
                            <div class="text-sm text-amber-400 mt-1 italic">"{{ $appointment->notes }}"</div>
                        @endif
                    </div>

                    <div class="flex-shrink-0">
                        <span class="inline-block px-6 py-2.5 rounded-2xl text-sm font-medium
                            @if($appointment->status == 'completed') bg-green-600 
                            @elseif($appointment->status == 'pending') bg-amber-600 
                            @elseif($appointment->status == 'cancelled') bg-red-700 
                            @else bg-zinc-700 @endif">
                            
                            @if($appointment->status == 'completed') Завершено
                            @elseif($appointment->status == 'pending') В ожидании
                            @elseif($appointment->status == 'cancelled') Отменено
                            @else {{ ucfirst($appointment->status) }}
                            @endif
                        </span>
                    </div>

                    <div class="flex gap-3">
                        @if($appointment->status == 'pending')
                            <form method="POST" action="{{ route('barber.appointments.status', $appointment) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="status" value="confirmed" 
                                        class="bg-green-600 hover:bg-green-700 px-5 py-3 rounded-2xl text-sm font-medium">
                                    Подтвердить
                                </button>
                            </form>
                        @endif

                        @if(in_array($appointment->status, ['pending','confirmed']))
                            <form method="POST" action="{{ route('barber.appointments.status', $appointment) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="status" value="completed" 
                                        class="bg-blue-600 hover:bg-blue-700 px-5 py-3 rounded-2xl text-sm font-medium">
                                    Завершить
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <!-- Будущие записи -->
        <div class="mt-16">
            <h2 class="text-2xl font-semibold mb-6">Ближайшие записи</h2>
            @if($upcomingAppointments->isEmpty())
                <p class="text-zinc-400">Ближайших записей нет</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($upcomingAppointments as $appointment)
                    <div class="bg-zinc-900 rounded-3xl p-6">
                        <div class="flex justify-between">
                            <div>
                                <div class="font-mono">{{ $appointment->appointment_date->format('d.m.Y') }}</div>
                                <div class="text-xl font-bold">
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}
                                </div>
                            </div>
                            <span class="text-xs bg-zinc-800 px-4 py-2 rounded-2xl self-start">
                                @if($appointment->status == 'pending') В ожидании
                                @elseif($appointment->status == 'confirmed') Подтверждено
                                @elseif($appointment->status == 'completed') Завершено
                                @elseif($appointment->status == 'cancelled') Отменено
                                @else {{ ucfirst($appointment->status) }}
                                @endif
                            </span>
                        </div>
                        <div class="mt-4">
                            <div class="font-medium">{{ $appointment->user?->name }}</div>
                            <div class="text-zinc-400 text-sm">{{ $appointment->service?->name }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection