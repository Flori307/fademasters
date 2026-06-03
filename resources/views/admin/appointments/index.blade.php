@extends('layouts.app')

@section('title', 'Управление записями — Админка')

@section('content')
<div class="bg-zinc-950 py-10 px-6 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-4xl font-bold">Все записи</h1>
            <div class="text-sm text-zinc-400">
                Всего записей: <span class="font-semibold text-white">{{ $appointments->total() }}</span>
            </div>
        </div>

        <!-- Фильтры -->
        <div class="bg-zinc-900 rounded-3xl p-6 mb-8">
            <form method="GET" action="{{ route('admin.appointments.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <select name="status" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-5 py-3">
                        <option value="">Все статусы</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>В ожидании</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершено</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменено</option>
                    </select>
                </div>

                <div>
                    <select name="barber_id" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-5 py-3">
                        <option value="">Все мастера</option>
                        @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}" {{ request('barber_id') == $barber->id ? 'selected' : '' }}>
                            {{ $barber->nickname }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-5 py-3">
                </div>

                <div>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-5 py-3">
                </div>

                <div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-2xl font-semibold">
                        Применить фильтры
                    </button>
                </div>
            </form>
        </div>

        <!-- Таблица записей -->
        <div class="bg-zinc-900 rounded-3xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-800">
                        <tr>
                            <th class="text-left p-5 text-sm font-medium text-zinc-400">Дата и время</th>
                            <th class="text-left p-5 text-sm font-medium text-zinc-400">Клиент</th>
                            <th class="text-left p-5 text-sm font-medium text-zinc-400">Мастер</th>
                            <th class="text-left p-5 text-sm font-medium text-zinc-400">Услуга</th>
                            <th class="text-center p-5 text-sm font-medium text-zinc-400">Статус</th>
                            <th class="text-right p-5 text-sm font-medium text-zinc-400">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($appointments as $appointment)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="p-5">
                                <div class="font-medium text-white">{{ $appointment->appointment_date->format('d.m.Y') }}</div>
                                <div class="text-sm text-zinc-500 font-mono">
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="font-medium">{{ $appointment->user?->name ?? '—' }}</div>
                                <div class="text-xs text-zinc-500">{{ $appointment->user?->phone ?? '' }}</div>
                             </td>
                            <td class="p-5 text-zinc-300">{{ $appointment->barber?->nickname ?? '—' }}</td>
                            <td class="p-5">
                                <div class="font-medium">{{ $appointment->service?->name ?? '—' }}</div>
                                <div class="text-xs text-zinc-500">{{ number_format($appointment->service?->price ?? 0) }} ₽</div>
                             </td>
                            <td class="p-5 text-center">
    <span class="inline-flex px-3 py-1.5 rounded-xl text-xs font-medium
        @if($appointment->status == 'completed') bg-green-600/20 text-green-400 border border-green-500/30
        @elseif($appointment->status == 'pending') bg-amber-600/20 text-amber-400 border border-amber-500/30
        @elseif($appointment->status == 'cancelled') bg-red-600/20 text-red-400 border border-red-500/30
        @else bg-zinc-700 text-zinc-300 @endif">
        {{ $appointment->status_label }}
    </span>
</td>
                            <td class="p-5 text-right">
    <div class="flex justify-end gap-2">
        @if($appointment->status == 'pending')
            <form method="POST" action="{{ route('admin.appointments.status', $appointment) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" name="status" value="completed" 
                        class="bg-green-600/20 hover:bg-green-600 text-green-400 hover:text-white px-4 py-2 rounded-xl text-xs font-medium transition-all">
                    Завершить
                </button>
            </form>
        @endif
        
        @if($appointment->status == 'pending')
            <form method="POST" action="{{ route('admin.appointments.status', $appointment) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" name="status" value="cancelled" 
                        class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white px-4 py-2 rounded-xl text-xs font-medium transition-all"
                        onclick="return confirm('Отменить запись?')">
                    Отменить
                </button>
            </form>
        @endif
    </div>
</td>
                         </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Пагинация -->
        <div class="mt-8">
            {{ $appointments->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection