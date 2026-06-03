@extends('layouts.app')

@section('title', 'Fade Masters — Барбершоп премиум-класса')

@section('content')
<div class="bg-zinc-950 text-zinc-200">

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-black via-zinc-900 to-black animate-gradient"></div>
        
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="relative z-10 text-center px-6 max-w-6xl mx-auto">
            <div class="inline-block mb-8 animate-fade-down">
                <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-6 py-2 text-sm font-medium tracking-wider">
                    ★ ПРЕМИУМ БАРБЕРШОП ★
                </span>
            </div>
            
            <h1 class="text-8xl md:text-9xl font-black tracking-tighter leading-none mb-6 animate-fade-up">
                <span class="bg-gradient-to-r from-red-500 via-white to-red-500 bg-clip-text text-transparent bg-300% animate-gradient-x">
                    FADE
                </span>
                <br>
                <span class="text-white">MASTERS</span>
            </h1>
            
            <p class="text-2xl md:text-3xl text-zinc-300 mb-12 max-w-3xl mx-auto animate-fade-up animation-delay-200">
                Мужской барбершоп в Челябинске
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center animate-fade-up animation-delay-400">
                <a href="{{ route('booking.create') }}" 
                   class="group relative bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold text-lg px-10 py-5 rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-red-500/25 overflow-hidden">
                    <span class="relative z-10">✂️ Записаться онлайн</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                </a>
                <a href="{{ route('services.index') }}" 
                   class="border-2 border-white/30 hover:border-red-500 hover:bg-red-500/10 font-bold text-lg px-10 py-5 rounded-2xl transition-all duration-300 backdrop-blur-sm">
                    📋 Смотреть услуги
                </a>
            </div>
        </div>
        
        
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                <div class="w-1 h-2 bg-white/50 rounded-full mt-2 animate-scroll"></div>
            </div>
        </div>
    </section>

    
    <section class="py-28 px-6 bg-gradient-to-b from-zinc-900 to-zinc-950">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-bold mb-4">Почему мы?</h2>
                <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group text-center p-8 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-7xl mb-6 group-hover:scale-110 transition-transform duration-300">✂️</div>
                    <h3 class="text-2xl font-bold mb-4">Профессиональные мастера</h3>
                    <p class="text-zinc-400 leading-relaxed">Опыт от 5 лет. Специализация на современных фейдах, андеркатах и классических стрижках.</p>
                </div>
                
                <div class="group text-center p-8 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-7xl mb-6 group-hover:scale-110 transition-transform duration-300">🪒</div>
                    <h3 class="text-2xl font-bold mb-4">Премиум косметика</h3>
                    <p class="text-zinc-400 leading-relaxed">Используем только лучшие бренды: American Crew, Reuzel, Uppercut Deluxe, MOROCCANOIL.</p>
                </div>
                
                <div class="group text-center p-8 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-7xl mb-6 group-hover:scale-110 transition-transform duration-300">⏱️</div>
                    <h3 class="text-2xl font-bold mb-4">Удобная онлайн-запись</h3>
                    <p class="text-zinc-400 leading-relaxed">Выбирайте мастера и время 24/7. Никаких звонков — всё онлайн за пару кликов.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-28 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <h2 class="text-5xl md:text-6xl font-bold mb-2">Популярные услуги</h2>
                    <p class="text-zinc-400 text-lg">Выберите то, что вам подходит</p>
                </div>
                <a href="{{ route('services.index') }}" class="group hidden md:flex items-center gap-2 text-red-500 hover:text-red-400 font-semibold transition-all">
                    <span>Все услуги</span>
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services->take(3) as $service)
                <div class="group relative bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl overflow-hidden border border-white/10 hover:border-red-500/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/10">
                    
                    <div class="absolute -right-8 -top-8 text-9xl opacity-5 group-hover:opacity-10 transition-opacity duration-500 rotate-12">
                        ✂️
                    </div>
                    
                    <div class="relative p-8">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-3xl font-bold tracking-tight mb-2 group-hover:text-red-500 transition-colors">{{ $service->name }}</h3>
                                @if($service->category)
                                <span class="text-xs text-zinc-500 px-3 py-1 rounded-full bg-white/5">{{ $service->category }}</span>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-4xl font-black text-white">{{ number_format($service->price, 0, ' ', ' ') }}</div>
                                <div class="text-xs text-zinc-500">рублей</div>
                            </div>
                        </div>

                        <p class="text-zinc-400 leading-relaxed mb-8 line-clamp-2">
                            {{ $service->description ?? 'Профессиональная услуга с индивидуальным подходом и качественными средствами.' }}
                        </p>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-zinc-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">{{ $service->duration_minutes }} минут</span>
                            </div>
                            
                            <a href="{{ route('booking.create') }}?service={{ $service->id }}" 
                               class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-xl text-sm font-semibold transition-all hover:scale-105 hover:shadow-lg">
                                Записаться →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            
            <div class="text-center mt-12 md:hidden">
                <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-red-500 hover:text-red-400 font-semibold">
                    <span>Все услуги</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Блок с мастерами -->
    @if($barbers->count() > 0)
    <section class="py-28 px-6 bg-gradient-to-t from-zinc-900 to-zinc-950">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-bold mb-4">Наши мастера</h2>
                <div class="w-20 h-1 bg-red-600 mx-auto rounded-full mb-6"></div>
                <p class="text-zinc-400 text-lg max-w-2xl mx-auto">Профессионалы, которые знают о мужском стиле всё</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($barbers as $barber)
                <div class="group relative">
                    <!-- Карточка мастера -->
                    <div class="relative bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl overflow-hidden border border-white/10 hover:border-red-500/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/20">
                        
                        <div class="relative h-80 overflow-hidden bg-gradient-to-br from-zinc-800 to-zinc-900">
                            @php
                                $photoPath = null;
                                if($barber->photo) {
                                    if(filter_var($barber->photo, FILTER_VALIDATE_URL)) {
                                        $photoPath = $barber->photo;
                                    } else {
                                        
                                        $possiblePaths = [
                                            'storage/' . $barber->photo,
                                            'storage/barbers/' . $barber->photo,
                                            $barber->photo
                                        ];
                                        
                                        foreach($possiblePaths as $path) {
                                            if(file_exists(public_path($path))) {
                                                $photoPath = asset($path);
                                                break;
                                            }
                                        }
                                        
                                        if(!$photoPath && Storage::disk('public')->exists($barber->photo)) {
                                            $photoPath = asset('storage/' . $barber->photo);
                                        }
                                        
                                        if(!$photoPath) {
                                            $photoPath = null;
                                        }
                                    }
                                }
                            @endphp
                            
                            @if($photoPath)
                                <img src="{{ $photoPath }}" 
                                    alt="{{ $barber->nickname }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-8xl bg-gradient-to-br from-zinc-800 to-zinc-900">
                                    @switch($loop->index % 5)
                                        @case(0) 👨‍🦰 @break
                                        @case(1) 👨‍🦱 @break
                                        @case(2) 🧔‍♂️ @break
                                        @case(3) 👨‍🦲 @break
                                        @default 💈
                                    @endswitch
                                </div>
                            @endif
                            
                            @if($barber->experience_years)
                            <div class="absolute top-4 right-4 bg-black/80 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full border border-white/20">
                                ⭐ {{ $barber->experience_years }} лет
                            </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end justify-center pb-6">
                                <a href="{{ route('booking.create') }}?barber={{ $barber->id }}" 
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl text-sm font-semibold transition-all transform translate-y-4 group-hover:translate-y-0">
                                    Записаться →
                                </a>
                            </div>
                        </div>
                        
                        <div class="p-6 text-center">
                            <h3 class="text-2xl font-bold mb-1 group-hover:text-red-500 transition-colors">
                                {{ $barber->nickname }}
                            </h3>
                            <p class="text-red-500 text-sm mb-3 font-medium">
                                {{ $barber->specialization ?? 'Master Barber' }}
                            </p>
                            
                            <div class="flex justify-center gap-1 mb-4">
                                <span class="text-yellow-500">★</span>
                                <span class="text-yellow-500">★</span>
                                <span class="text-yellow-500">★</span>
                                <span class="text-yellow-500">★</span>
                                <span class="text-zinc-600">★</span>
                                <span class="text-xs text-zinc-500 ml-2">(12)</span>
                            </div>
                            
                            <p class="text-zinc-400 text-sm leading-relaxed line-clamp-2 mb-4">
                                {{ $barber->description ?? 'Профессиональный барбер с опытом работы. Специализируется на современных стрижках и уходе за бородой.' }}
                            </p>
                            
                            <a href="{{ route('barbers.show', $barber) }}" 
                            class="inline-flex items-center gap-2 text-sm text-zinc-400 hover:text-white transition-colors group/link">
                                <span>Подробнее</span>
                                <span class="group-hover/link:translate-x-1 transition-transform">→</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('barbers.index') }}" 
                class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 px-8 py-4 rounded-2xl font-semibold transition-all hover:scale-105">
                    <span>Все мастера</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Блок с отзывами -->
    <section class="py-28 px-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=2070')] bg-cover bg-center opacity-10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-transparent to-zinc-950"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto text-center">
            <div class="text-6xl mb-6">⭐</div>
            <h3 class="text-3xl md:text-4xl font-bold mb-6">Более 2000 довольных клиентов</h3>
            <p class="text-zinc-300 text-lg mb-10 max-w-2xl mx-auto">"Лучший барбершоп в городе! Всегда чисто, профессионально и с душой. Мастера реально понимают, что нужно клиенту."</p>
            <div class="flex justify-center gap-1 text-yellow-500 text-2xl mb-8">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
            <a href="{{ route('booking.create') }}" 
               class="inline-block bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold px-10 py-5 rounded-2xl transition-all hover:scale-105">
                Записаться сейчас
            </a>
        </div>
    </section>
</div>

<style>
    @keyframes fade-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fade-down {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes gradient-x {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }
    
    @keyframes scroll {
        0% {
            opacity: 1;
            transform: translateY(0);
        }
        100% {
            opacity: 0;
            transform: translateY(16px);
        }
    }
    
    .animate-fade-up {
        animation: fade-up 0.8s ease-out forwards;
    }
    
    .animate-fade-down {
        animation: fade-down 0.8s ease-out forwards;
    }
    
    .animate-gradient-x {
        background-size: 300% 300%;
        animation: gradient-x 6s ease infinite;
    }
    
    .animate-scroll {
        animation: scroll 1.5s ease-in-out infinite;
    }
    
    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }
    
    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }
    
    .bg-300\% {
        background-size: 300%;
    }
</style>
@endsection