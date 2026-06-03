@extends('layouts.app')

@section('title', 'О нас — Fade Masters')

@section('content')
<div class="bg-zinc-950 text-zinc-200">
    
    <!-- Hero секция -->
    <section class="relative pt-32 pb-20 px-6 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-red-900/20 via-transparent to-transparent"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-red-600/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto text-center">
            <div class="inline-block mb-6 animate-fade-down">
                <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-6 py-2 text-sm font-medium tracking-wider">
                    📖 НАША ИСТОРИЯ
                </span>
            </div>
            <h1 class="text-6xl md:text-8xl font-black tracking-tighter mb-6 animate-fade-up">
                <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                    О нас
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-zinc-400 max-w-3xl mx-auto animate-fade-up animation-delay-200">
                История, философия и ценности нашего барбершопа
            </p>
        </div>
    </section>

    <!-- История -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="order-2 md:order-1">
                    <div class="inline-block mb-4">
                        <span class="text-red-500 font-semibold tracking-wider">НАША ИСТОРИЯ</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        Как всё начиналось
                    </h2>
                    <div class="space-y-6 text-zinc-300 leading-relaxed">
                        <p>
                            <span class="font-bold text-white">Fade Masters</span> основан в 2020 году двумя друзьями-барберами, 
                            которые мечтали создать место, где мужской стиль и уход возведены в абсолют. 
                            Начинали с маленькой студии в центре Челябинска, а сегодня — один из лучших 
                            барбершопов города.
                        </p>
                        <p>
                            За 5 лет работы мы обучили десятки мастеров, обслужили более <span class="text-red-500 font-bold">2000 клиентов</span> 
                            и создали команду профессионалов, которые искренне любят своё дело.
                        </p>
                        <p>
                            Сегодня <span class="text-red-500 font-bold">Fade Masters</span> — это не просто стрижка, 
                            это целая культура, атмосфера и подход, который делает каждого клиента увереннее и стильнее.
                        </p>
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-gradient-to-r from-red-600 to-red-800 rounded-3xl opacity-20 group-hover:opacity-40 blur-xl transition-all duration-500"></div>
                        <div class="relative rounded-3xl overflow-hidden border border-white/10">
                            <img src="https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=2070" 
                                 alt="Барбершоп интерьер"
                                 class="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                        <div class="absolute -bottom-6 -right-6 bg-red-600 rounded-2xl px-6 py-4 shadow-xl">
                            <div class="text-3xl font-bold">{{ $barbers->where('experience_years', '>=', 5)->count() }}+</div>
                            <div class="text-sm opacity-90">лет работы</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Наши ценности -->
    <section class="py-20 px-6 bg-gradient-to-b from-zinc-900/50 to-transparent">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-block mb-4">
                    <span class="text-red-500 font-semibold tracking-wider">НАШИ ЦЕННОСТИ</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Философия Fade Masters
                </h2>
                <p class="text-xl text-zinc-400 max-w-2xl mx-auto">
                    Принципы, на которых строится наша работа
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="group text-center p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">💎</div>
                    <h3 class="text-2xl font-bold mb-4">Качество</h3>
                    <p class="text-zinc-400 leading-relaxed">
                        Используем только премиальную косметику и профессиональный инструмент. Каждая стрижка — результат индивидуального подхода.
                    </p>
                </div>

                <div class="group text-center p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">🤝</div>
                    <h3 class="text-2xl font-bold mb-4">Доверие</h3>
                    <p class="text-zinc-400 leading-relaxed">
                        Открытость, честность и уважение к каждому клиенту. Мы ценим ваше время и доверие.
                    </p>
                </div>

                <div class="group text-center p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform">📈</div>
                    <h3 class="text-2xl font-bold mb-4">Развитие</h3>
                    <p class="text-zinc-400 leading-relaxed">
                        Мастера регулярно повышают квалификацию, посещают курсы и мастер-классы топовых барберов.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Команда (из БД) -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-block mb-4">
                    <span class="text-red-500 font-semibold tracking-wider">НАША КОМАНДА</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Сердце барбершопа
                </h2>
                <p class="text-xl text-zinc-400 max-w-2xl mx-auto">
                    Профессионалы, которые делают вас стильными
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($barbers->take(3) as $barber)
                <div class="group bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl overflow-hidden border border-white/10 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="h-80 overflow-hidden bg-gradient-to-br from-zinc-800 to-zinc-900">
                        @php
                            $photoExists = false;
                            $photoUrl = null;
                            
                            if($barber->photo) {
                                if(filter_var($barber->photo, FILTER_VALIDATE_URL)) {
                                    $photoUrl = $barber->photo;
                                    $photoExists = true;
                                } else {
                                    $paths = [
                                        'storage/' . $barber->photo,
                                        'storage/barbers/' . $barber->photo,
                                        'barbers/' . $barber->photo,
                                        $barber->photo
                                    ];
                                    
                                    foreach($paths as $path) {
                                        if(file_exists(public_path($path))) {
                                            $photoUrl = asset($path);
                                            $photoExists = true;
                                            break;
                                        }
                                    }
                                    
                                    if(!$photoExists && \Illuminate\Support\Facades\Storage::disk('public')->exists($barber->photo)) {
                                        $photoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($barber->photo);
                                        $photoExists = true;
                                    }
                                }
                            }
                        @endphp
                        
                        @if($photoExists)
                            <img src="{{ $photoUrl }}" 
                                 alt="{{ $barber->nickname }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-8xl bg-gradient-to-br from-zinc-800 to-zinc-900">
                                👨‍🦰
                            </div>
                        @endif
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold mb-1">{{ $barber->nickname }}</h3>
                        <p class="text-red-500 text-sm mb-3">{{ $barber->specialization ?? 'Professional Barber' }}</p>
                        <p class="text-zinc-400 text-sm">Опыт: {{ $barber->experience_years ?? '?' }} лет</p>
                    </div>
                </div>
                @endforeach
            </div>

            @if($barbers->count() > 3)
            <div class="text-center mt-10">
                <a href="{{ route('barbers.index') }}" 
                   class="inline-flex items-center gap-2 text-red-500 hover:text-red-400 font-semibold transition-all">
                    <span>Смотреть всех мастеров ({{ $barbers->count() }})</span>
                    <span>→</span>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Преимущества в цифрах -->
    <section class="py-20 px-6 bg-gradient-to-b from-zinc-900/50 to-transparent">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-6">
                    <div class="text-5xl font-black text-red-500 mb-2">{{ $totalClients ?? '2000+' }}</div>
                    <div class="text-sm text-zinc-400">Довольных клиентов</div>
                </div>
                <div class="p-6">
                    <div class="text-5xl font-black text-red-500 mb-2">{{ $totalAppointments ?? '15K+' }}</div>
                    <div class="text-sm text-zinc-400">Выполненных стрижек</div>
                </div>
                <div class="p-6">
                    <div class="text-5xl font-black text-red-500 mb-2">{{ $avgExperience ?? '8' }}+</div>
                    <div class="text-sm text-zinc-400">Лет средний опыт</div>
                </div>
                <div class="p-6">
                    <div class="text-5xl font-black text-red-500 mb-2">{{ $totalAwards ?? '50' }}+</div>
                    <div class="text-sm text-zinc-400">Наград и сертификатов</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA блок -->
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto text-center bg-gradient-to-br from-red-600/10 to-transparent rounded-3xl p-12 border border-red-500/20">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Станьте частью нашей истории</h2>
            <p class="text-zinc-400 mb-8 text-lg">Запишитесь на стрижку и почувствуйте разницу</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('booking.create') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 px-8 py-4 rounded-2xl font-semibold transition-all hover:scale-105">
                    ✂️ Записаться онлайн
                </a>
                <a href="{{ route('services.index') }}" 
                   class="inline-flex items-center justify-center gap-2 border border-white/30 hover:bg-white/10 px-8 py-4 rounded-2xl font-semibold transition-all">
                    📋 Посмотреть услуги
                </a>
            </div>
        </div>
    </section>
</div>

<!-- CSS анимации -->
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
    
    .animate-fade-up {
        animation: fade-up 0.8s ease-out forwards;
    }
    
    .animate-fade-down {
        animation: fade-down 0.8s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }
</style>
@endsection