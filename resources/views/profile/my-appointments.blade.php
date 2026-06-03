@extends('layouts.app')

@section('title', 'Мои записи — Fade Masters')

@section('content')
<div class="bg-zinc-950 min-h-screen">
    
    <!-- Hero секция -->
    <section class="relative pt-20 pb-12 px-6 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-red-900/10 via-transparent to-transparent"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="inline-block mb-4">
                        <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium tracking-wider">
                            📋 МОИ ЗАПИСИ
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tighter">
                        <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                            Мои записи
                        </span>
                    </h1>
                    <p class="text-zinc-400 mt-2">История ваших визитов в барбершоп</p>
                </div>
                
                <a href="{{ route('booking.create') }}" 
                   class="flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 px-6 py-3 rounded-2xl font-semibold transition-all hover:scale-105">
                    <span>+ Новая запись</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Содержимое -->
    <section class="py-8 px-6 pb-20">
        <div class="max-w-7xl mx-auto">
            
            <!-- Фильтры по статусу -->
            @if(!$appointments->isEmpty())
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="filter-btn active bg-red-600 text-white px-6 py-2 rounded-full text-sm font-medium transition-all" data-filter="all">
                    Все записи
                </button>
                <button class="filter-btn bg-white/5 hover:bg-white/10 text-zinc-300 px-6 py-2 rounded-full text-sm font-medium transition-all" data-filter="pending">
                    ⏳ Ожидают
                </button>
                <button class="filter-btn bg-white/5 hover:bg-white/10 text-zinc-300 px-6 py-2 rounded-full text-sm font-medium transition-all" data-filter="confirmed">
                    ✅ Подтверждены
                </button>
                <button class="filter-btn bg-white/5 hover:bg-white/10 text-zinc-300 px-6 py-2 rounded-full text-sm font-medium transition-all" data-filter="completed">
                    ✔️ Завершены
                </button>
                <button class="filter-btn bg-white/5 hover:bg-white/10 text-zinc-300 px-6 py-2 rounded-full text-sm font-medium transition-all" data-filter="cancelled">
                    ❌ Отменены
                </button>
            </div>
            @endif

            @if($appointments->isEmpty())
                <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl p-20 text-center border border-white/10">
                    <div class="text-8xl mb-6">📅</div>
                    <p class="text-2xl text-zinc-400 mb-4">У вас пока нет записей</p>
                    <p class="text-zinc-500 mb-8">Запишитесь на стрижку или уход за бородой прямо сейчас</p>
                    <a href="{{ route('booking.create') }}" class="inline-block bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 px-10 py-5 rounded-2xl font-semibold transition-all hover:scale-105">
                        📅 Записаться сейчас
                    </a>
                </div>
            @else
                <!-- Сетка 2 колонки -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($appointments as $appointment)
                    <div class="appointment-card group bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl border border-white/10 hover:border-red-500/40 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-red-500/10 overflow-hidden"
                         data-status="{{ $appointment->status }}">
                        
                        <!-- Верхняя полоса статуса -->
                        <div class="h-1.5 w-full
                            @if($appointment->status == 'confirmed') bg-gradient-to-r from-emerald-600 to-emerald-400
                            @elseif($appointment->status == 'pending') bg-gradient-to-r from-amber-600 to-amber-400
                            @elseif($appointment->status == 'completed') bg-gradient-to-r from-blue-600 to-blue-400
                            @elseif($appointment->status == 'cancelled') bg-gradient-to-r from-red-700 to-red-500
                            @else bg-gradient-to-r from-zinc-700 to-zinc-500 @endif">
                        </div>
                        
                        <div class="p-6">
                            <!-- Верхняя часть: дата и статус -->
                            <div class="flex justify-between items-start mb-5">
                                <!-- Дата -->
                                <div class="flex items-center gap-4">
                                    <div class="text-center">
                                        <div class="text-5xl font-black text-white leading-none">
                                            {{ $appointment->appointment_date->format('d') }}
                                        </div>
                                        @php
                                            $months = [
                                                'January' => 'Янв', 'February' => 'Фев', 'March' => 'Мар',
                                                'April' => 'Апр', 'May' => 'Май', 'June' => 'Июн',
                                                'July' => 'Июл', 'August' => 'Авг', 'September' => 'Сен',
                                                'October' => 'Окт', 'November' => 'Ноя', 'December' => 'Дек'
                                            ];
                                            $monthName = $appointment->appointment_date->format('F');
                                            $monthRu = $months[$monthName] ?? $monthName;
                                        @endphp
                                        <div class="text-sm font-semibold text-red-500">{{ $monthRu }}</div>
                                    </div>
                                    
                                    <div class="h-12 w-px bg-white/10"></div>
                                    
                                    <div>
                                        <div class="flex items-center gap-1.5 text-zinc-400 text-sm mb-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            @php
                                                $weekdays = [
                                                    'Monday' => 'ПН', 'Tuesday' => 'ВТ', 'Wednesday' => 'СР',
                                                    'Thursday' => 'ЧТ', 'Friday' => 'ПТ', 'Saturday' => 'СБ',
                                                    'Sunday' => 'ВС'
                                                ];
                                                $weekdayName = $appointment->appointment_date->format('l');
                                                $weekdayRu = $weekdays[$weekdayName] ?? $weekdayName;
                                            @endphp
                                            <span>{{ $weekdayRu }}</span>
                                        </div>
                                        <div class="text-2xl font-mono font-bold text-white">
                                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Статус бейдж -->
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium
                                    @if($appointment->status == 'confirmed') bg-emerald-600/20 text-emerald-400 border border-emerald-500/30
                                    @elseif($appointment->status == 'pending') bg-amber-600/20 text-amber-400 border border-amber-500/30
                                    @elseif($appointment->status == 'completed') bg-blue-600/20 text-blue-400 border border-blue-500/30
                                    @elseif($appointment->status == 'cancelled') bg-red-600/20 text-red-400 border border-red-500/30
                                    @else bg-zinc-700 text-zinc-300 @endif">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        @if($appointment->status == 'confirmed') bg-emerald-400
                                        @elseif($appointment->status == 'pending') bg-amber-400
                                        @elseif($appointment->status == 'completed') bg-blue-400
                                        @elseif($appointment->status == 'cancelled') bg-red-400
                                        @endif">
                                    </span>
                                    @if($appointment->status == 'confirmed') Подтверждено
                                    @elseif($appointment->status == 'pending') Ожидает
                                    @elseif($appointment->status == 'completed') Завершено
                                    @elseif($appointment->status == 'cancelled') Отменено
                                    @else {{ ucfirst($appointment->status) }}
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Услуга и мастер -->
                            <div class="mb-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-2xl">✂️</span>
                                    <h3 class="text-xl font-bold group-hover:text-red-500 transition-colors">
                                        {{ $appointment->service->name }}
                                    </h3>
                                </div>
                                
                                <div class="flex items-center gap-3 text-sm text-zinc-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $appointment->service->duration_minutes }} мин
                                    </span>
                                    <span class="w-1 h-1 bg-zinc-600 rounded-full"></span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ number_format($appointment->service->price) }} ₽
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Мастер -->
                            <div class="flex items-center justify-between py-3 border-t border-b border-white/5 mb-4">
                                <div class="flex items-center gap-2 text-sm text-zinc-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Мастер:</span>
                                </div>
                                <span class="font-semibold text-white">{{ $appointment->barber->nickname }}</span>
                            </div>
                            
                            <!-- Заметки (если есть) -->
                            @if($appointment->notes)
                                <div class="mb-5 p-3 bg-amber-500/5 rounded-xl border border-amber-500/15">
                                    <p class="text-sm text-amber-400/80 flex items-start gap-2">
                                        <span>💭</span>
                                        <span class="flex-1 line-clamp-2">“{{ $appointment->notes }}”</span>
                                    </p>
                                </div>
                            @endif
                            
                            <!-- Действия -->
                            <div class="flex flex-wrap gap-3 pt-2">
                                @if(in_array($appointment->status, ['pending', 'confirmed']) && !$appointment->appointment_date->isPast())
                                    <form method="POST" action="{{ route('appointments.cancel', $appointment) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-sm text-red-400 hover:text-red-300 transition-colors flex items-center gap-1.5 px-3 py-1.5 rounded-xl hover:bg-red-400/10"
                                                onclick="return confirm('Вы уверены, что хотите отменить запись?')">
                                            ❌ Отменить
                                        </button>
                                    </form>
                                @endif
                                
                                @if($appointment->status == 'completed' && !$appointment->review)
                                    <a href="{{ route('reviews.create', $appointment->barber) }}?appointment_id={{ $appointment->id }}" 
                                       class="text-sm text-green-400 hover:text-green-300 transition-colors flex items-center gap-1.5 px-3 py-1.5 rounded-xl hover:bg-green-400/10">
                                        📝 Оставить отзыв
                                    </a>
                                @endif
                                
                                @if($appointment->review)
                                    <span class="text-sm text-zinc-500 flex items-center gap-1.5 px-3 py-1.5">
                                        ✅ Отзыв оставлен
                                    </span>
                                @endif
                                
                                @if($appointment->status == 'confirmed')
                                    <span class="text-sm text-emerald-500/60 flex items-center gap-1.5 px-3 py-1.5">
                                        📧 Напомним о визите
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Статистика -->
                <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gradient-to-br from-white/5 to-transparent rounded-2xl p-4 text-center border border-white/5">
                        <div class="text-3xl font-bold text-white">{{ $appointments->count() }}</div>
                        <div class="text-xs text-zinc-500 mt-1">Всего записей</div>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-600/10 to-transparent rounded-2xl p-4 text-center border border-emerald-500/20">
                        <div class="text-3xl font-bold text-emerald-400">
                            {{ $appointments->where('status', 'confirmed')->count() }}
                        </div>
                        <div class="text-xs text-zinc-500 mt-1">Подтверждено</div>
                    </div>
                    <div class="bg-gradient-to-br from-amber-600/10 to-transparent rounded-2xl p-4 text-center border border-amber-500/20">
                        <div class="text-3xl font-bold text-amber-400">
                            {{ $appointments->where('status', 'pending')->count() }}
                        </div>
                        <div class="text-xs text-zinc-500 mt-1">Ожидают</div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-600/10 to-transparent rounded-2xl p-4 text-center border border-blue-500/20">
                        <div class="text-3xl font-bold text-blue-400">
                            {{ $appointments->where('status', 'completed')->count() }}
                        </div>
                        <div class="text-xs text-zinc-500 mt-1">Завершено</div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

<!-- JavaScript для фильтрации -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.appointment-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
                b.classList.remove('active', 'bg-red-600', 'text-white');
                b.classList.add('bg-white/5', 'text-zinc-300');
            });
            
            this.classList.add('active', 'bg-red-600', 'text-white');
            this.classList.remove('bg-white/5', 'text-zinc-300');
            
            const filter = this.dataset.filter;
            
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.status === filter) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
});
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection