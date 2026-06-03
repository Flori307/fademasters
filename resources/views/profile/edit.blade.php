@extends('layouts.app')

@section('title', 'Мой профиль — Fade Masters')

@section('content')
<div class="bg-zinc-950 min-h-screen">
    
    <!-- Hero секция -->
    <section class="relative pt-20 pb-12 px-6 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-red-900/10 via-transparent to-transparent"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-3xl mx-auto">
            <div class="inline-block mb-4">
                <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium tracking-wider">
                    👤 ЛИЧНЫЙ КАБИНЕТ
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black tracking-tighter">
                <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                    Мой профиль
                </span>
            </h1>
            <p class="text-zinc-400 mt-2">Управляйте своими данными и настройками</p>
        </div>
    </section>

    <!-- Форма профиля -->
    <section class="py-8 px-6 pb-20">
        <div class="max-w-3xl mx-auto">
            <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl p-8 md:p-10 border border-white/10 shadow-2xl">
                
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Имя -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Имя и фамилия
                            </label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                   class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none transition-all">
                            @error('name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email адрес
                            </label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                   class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none transition-all">
                            @error('email')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Телефон -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Номер телефона
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="+7 (999) 123-45-67"
                                   class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none transition-all">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-zinc-500 mt-2">Укажите номер для связи с вами</p>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 py-4 rounded-2xl font-semibold text-lg transition-all hover:scale-[1.02]">
                            💾 Сохранить изменения
                        </button>
                        <a href="{{ route('profile.appointments') }}" 
                           class="flex-1 text-center border border-white/20 hover:bg-white/5 py-4 rounded-2xl font-semibold text-lg transition-all">
                            📋 Мои записи
                        </a>
                    </div>
                </form>

                <!-- Дополнительная информация -->
                <div class="mt-10 pt-8 border-t border-white/10">
                    <div class="flex flex-wrap justify-between items-center gap-4">
                        <div>
                            <p class="text-sm text-zinc-500">Дата регистрации</p>
                            <p class="font-medium">{{ auth()->user()->created_at->format('d.m.Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500">Всего записей</p>
                            <p class="font-medium">{{ auth()->user()->appointments()->count() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500">Последний визит</p>
                            <p class="font-medium">
                                @php
                                    $lastAppointment = auth()->user()->appointments()->where('status', 'completed')->latest('appointment_date')->first();
                                @endphp
                                {{ $lastAppointment ? $lastAppointment->appointment_date->format('d.m.Y') : '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Кнопка выхода -->
                <div class="mt-8 pt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center text-red-400 hover:text-red-300 py-3 rounded-xl text-sm transition-colors">
                            Выйти из аккаунта
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection