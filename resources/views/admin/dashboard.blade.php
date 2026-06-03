@extends('layouts.app')

@section('title', 'Админ-панель — Fade Masters')

@section('content')
<div class="bg-zinc-950 py-10 px-6 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Header с приветствием -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <div class="inline-block mb-2">
                    <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 text-xs font-medium tracking-wider">
                        АДМИН-ПАНЕЛЬ
                    </span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tighter">
                    <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                        Fade Masters
                    </span>
                </h1>
                <p class="text-zinc-400 mt-2">Управление барбершопом в одном месте</p>
            </div>
            
            <div class="text-right">
                <div class="text-2xl font-bold text-white">{{ now()->format('d.m.Y') }}</div>
                <div class="text-sm text-zinc-500">
                    @php
                        $weekdays = ['Monday' => 'Понедельник', 'Tuesday' => 'Вторник', 'Wednesday' => 'Среда', 'Thursday' => 'Четверг', 'Friday' => 'Пятница', 'Saturday' => 'Суббота', 'Sunday' => 'Воскресенье'];
                    @endphp
                    {{ $weekdays[now()->format('l')] ?? now()->format('l') }}
                </div>
            </div>
        </div>

        <!-- Статистика -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-12">
            <a href="{{ route('admin.appointments.index') }}" class="group bg-gradient-to-br from-zinc-900 to-zinc-950 p-6 rounded-3xl border border-white/10 hover:border-red-500/50 transition-all hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-2xl">📋</span>
                    <span class="text-xs text-zinc-500">Всего</span>
                </div>
                <p class="text-4xl font-bold mt-2">{{ $stats['total_appointments'] }}</p>
                <p class="text-sm text-zinc-500 mt-1">записей</p>
            </a>
            
            <a href="{{ route('admin.appointments.index', ['date_from' => now()->format('Y-m-d'), 'date_to' => now()->format('Y-m-d')]) }}" 
               class="group bg-gradient-to-br from-zinc-900 to-zinc-950 p-6 rounded-3xl border border-white/10 hover:border-red-500/50 transition-all hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-2xl">📅</span>
                    <span class="text-xs text-zinc-500">Сегодня</span>
                </div>
                <p class="text-4xl font-bold mt-2 text-red-500">{{ $stats['today_appointments'] }}</p>
                <p class="text-sm text-zinc-500 mt-1">записей</p>
            </a>
            
            <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" 
               class="group bg-gradient-to-br from-zinc-900 to-zinc-950 p-6 rounded-3xl border border-white/10 hover:border-red-500/50 transition-all hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-2xl">⏳</span>
                    <span class="text-xs text-zinc-500">Ожидают</span>
                </div>
                <p class="text-4xl font-bold mt-2 text-amber-500">{{ $stats['pending_appointments'] }}</p>
                <p class="text-sm text-zinc-500 mt-1">подтверждения</p>
            </a>
            
            <a href="{{ route('admin.barbers.index') }}" 
               class="group bg-gradient-to-br from-zinc-900 to-zinc-950 p-6 rounded-3xl border border-white/10 hover:border-red-500/50 transition-all hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-2xl">👨‍🦰</span>
                    <span class="text-xs text-zinc-500">Мастера</span>
                </div>
                <p class="text-4xl font-bold mt-2">{{ $stats['total_barbers'] }}</p>
                <p class="text-sm text-zinc-500 mt-1">активных</p>
            </a>
            
            <a href="{{ route('admin.services.index') }}" 
               class="group bg-gradient-to-br from-zinc-900 to-zinc-950 p-6 rounded-3xl border border-white/10 hover:border-red-500/50 transition-all hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-2xl">💈</span>
                    <span class="text-xs text-zinc-500">Услуги</span>
                </div>
                <p class="text-4xl font-bold mt-2">{{ $stats['total_services'] }}</p>
                <p class="text-sm text-zinc-500 mt-1">активных</p>
            </a>
            
            <a href="{{ route('admin.reviews.index') }}" 
               class="group bg-gradient-to-br from-zinc-900 to-zinc-950 p-6 rounded-3xl border border-white/10 hover:border-red-500/50 transition-all hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-2xl">⭐</span>
                    <span class="text-xs text-zinc-500">Отзывы</span>
                </div>
                <p class="text-4xl font-bold mt-2">{{ $stats['total_clients'] }}</p>
                <p class="text-sm text-zinc-500 mt-1">клиентов</p>
            </a>
        </div>

        <!-- Отзывы на модерации -->
        @if(isset($pendingReviews) && $pendingReviews > 0)
        <div class="mb-12">
            <a href="{{ route('admin.reviews.index', ['filter' => 'pending']) }}" 
               class="block bg-gradient-to-r from-amber-600/10 to-transparent rounded-3xl p-6 border border-amber-500/30 hover:border-amber-500/50 transition-all">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-500/20 rounded-2xl flex items-center justify-center text-xl">
                            ⭐
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Новые отзывы на модерации</h3>
                            <p class="text-sm text-zinc-400">{{ $pendingReviews }} отзывов ожидают проверки</p>
                        </div>
                    </div>
                    <div class="text-amber-400 text-sm flex items-center gap-1">
                        <span>Перейти к отзывам</span>
                        <span>→</span>
                    </div>
                </div>
            </a>
        </div>
        @endif

        <!-- Записи на сегодня -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold flex items-center gap-2">
                    <span>📅</span>
                    <span>Записи на сегодня</span>
                    <span class="text-sm text-zinc-500">({{ now()->format('d.m.Y') }})</span>
                </h2>
                <a href="{{ route('admin.appointments.index') }}" class="text-sm text-red-500 hover:text-red-400 transition-colors flex items-center gap-1">
                    <span>Все записи</span>
                    <span>→</span>
                </a>
            </div>

            @if($todayAppointments->isEmpty())
                <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl p-16 text-center border border-white/10">
                    <div class="text-5xl mb-4">📭</div>
                    <p class="text-xl text-zinc-400">Записей на сегодня нет</p>
                </div>
            @else
                <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl overflow-hidden border border-white/10">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-zinc-800/50">
                                <tr>
                                    <th class="text-left p-5 text-sm font-medium text-zinc-400">Время</th>
                                    <th class="text-left p-5 text-sm font-medium text-zinc-400">Клиент</th>
                                    <th class="text-left p-5 text-sm font-medium text-zinc-400">Мастер</th>
                                    <th class="text-left p-5 text-sm font-medium text-zinc-400">Услуга</th>
                                    <th class="text-center p-5 text-sm font-medium text-zinc-400">Статус</th>
                                    <th class="text-right p-5 text-sm font-medium text-zinc-400"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($todayAppointments as $app)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-5">
                                        <span class="font-mono text-lg font-bold text-white">{{ \Carbon\Carbon::parse($app->start_time)->format('H:i') }}</span>
                                    </td>
                                    <td class="p-5">
                                        <div class="font-medium">{{ $app->user?->name ?? '—' }}</div>
                                        <div class="text-xs text-zinc-500">{{ $app->user?->phone ?? '' }}</div>
                                    </td>
                                    <td class="p-5">
                                        <a href="{{ route('admin.barbers.edit', $app->barber) }}" class="hover:text-red-400 transition">
                                            {{ $app->barber?->nickname ?? '—' }}
                                        </a>
                                    </td>
                                    <td class="p-5">
                                        <a href="{{ route('admin.services.edit', $app->service) }}" class="hover:text-red-400 transition">
                                            {{ $app->service?->name ?? '—' }}
                                        </a>
                                        <div class="text-xs text-zinc-500">{{ number_format($app->service?->price ?? 0) }} ₽</div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="inline-flex px-3 py-1.5 rounded-xl text-xs font-medium
                                            @if($app->status == 'confirmed') bg-emerald-600/20 text-emerald-400 border border-emerald-500/30
                                            @elseif($app->status == 'pending') bg-amber-600/20 text-amber-400 border border-amber-500/30
                                            @elseif($app->status == 'completed') bg-blue-600/20 text-blue-400 border border-blue-500/30
                                            @elseif($app->status == 'cancelled') bg-red-600/20 text-red-400 border border-red-500/30
                                            @else bg-zinc-700 text-zinc-300 @endif">
                                            @if($app->status == 'confirmed') Подтверждено
                                            @elseif($app->status == 'pending') Ожидает
                                            @elseif($app->status == 'completed') Завершено
                                            @elseif($app->status == 'cancelled') Отменено
                                            @else {{ ucfirst($app->status) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="p-5 text-right">
                                        <a href="{{ route('admin.appointments.index', ['barber_id' => $app->barber_id]) }}" 
                                           class="text-zinc-500 hover:text-white transition-colors text-sm">
                                            Смотреть →
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Быстрые ссылки -->
        <div>
            <h2 class="text-2xl font-semibold mb-6">Быстрое управление</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('admin.services.index') }}" 
                   class="group bg-gradient-to-br from-zinc-900 to-zinc-950 hover:from-red-900/20 hover:to-zinc-900 p-6 rounded-3xl transition-all duration-300 border border-white/10 hover:border-red-500/50 hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-red-600/20 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">💈</div>
                        <div>
                            <h3 class="text-xl font-semibold">Услуги</h3>
                            <p class="text-sm text-zinc-500">Добавление, цены</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.barbers.index') }}" 
                   class="group bg-gradient-to-br from-zinc-900 to-zinc-950 hover:from-red-900/20 hover:to-zinc-900 p-6 rounded-3xl transition-all duration-300 border border-white/10 hover:border-red-500/50 hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-red-600/20 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">👨‍🦰</div>
                        <div>
                            <h3 class="text-xl font-semibold">Мастера</h3>
                            <p class="text-sm text-zinc-500">Найм, график</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.appointments.index') }}" 
                   class="group bg-gradient-to-br from-zinc-900 to-zinc-950 hover:from-red-900/20 hover:to-zinc-900 p-6 rounded-3xl transition-all duration-300 border border-white/10 hover:border-red-500/50 hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-red-600/20 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">📋</div>
                        <div>
                            <h3 class="text-xl font-semibold">Записи</h3>
                            <p class="text-sm text-zinc-500">Управление записями</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.reviews.index') }}" 
                   class="group bg-gradient-to-br from-zinc-900 to-zinc-950 hover:from-red-900/20 hover:to-zinc-900 p-6 rounded-3xl transition-all duration-300 border border-white/10 hover:border-red-500/50 hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-red-600/20 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">⭐</div>
                        <div>
                            <h3 class="text-xl font-semibold">Отзывы</h3>
                            <p class="text-sm text-zinc-500">Модерация отзывов</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection