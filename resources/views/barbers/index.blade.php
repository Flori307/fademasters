@extends('layouts.app')

@section('title', 'Наши мастера — Fade Masters')

@section('content')
<div class="bg-zinc-950">
    
    <!-- Hero секция с градиентом -->
    <section class="relative pt-32 pb-20 px-6 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-red-900/20 via-transparent to-transparent"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-red-600/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto text-center">
            <div class="inline-block mb-6 animate-fade-down">
                <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-6 py-2 text-sm font-medium tracking-wider">
                    НАША КОМАНДА
                </span>
            </div>
            <h1 class="text-6xl md:text-8xl font-black tracking-tighter mb-6 animate-fade-up">
                <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                    Наши
                </span>
                <br>
                <span class="text-white">мастера</span>
            </h1>
            <p class="text-xl md:text-2xl text-zinc-400 max-w-3xl mx-auto animate-fade-up animation-delay-200">
                Профессионалы с большим опытом и страстью к своему делу
            </p>
            
            <!-- Статистика -->
            <div class="flex flex-wrap justify-center gap-8 mt-12 animate-fade-up animation-delay-400">
                <div>
                    <div class="text-3xl font-bold text-red-500">{{ $barbers->count() }}</div>
                    <div class="text-sm text-zinc-500">Мастеров</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-red-500">
                        {{ $barbers->avg('experience_years') ? round($barbers->avg('experience_years')) : 5 }}+
                    </div>
                    <div class="text-sm text-zinc-500">Лет средний опыт</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-red-500">2000+</div>
                    <div class="text-sm text-zinc-500">Довольных клиентов</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Сетка мастеров -->
    <section class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($barbers as $barber)
                @php
                    $reviewsCount = $barber->reviews()->where('is_approved', true)->count();
                    $avgRating = $barber->reviews()->where('is_approved', true)->avg('rating') ?? 0;
                    $fullStars = floor($avgRating);
                    $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                @endphp
                <div class="group">
                    <div class="relative bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl overflow-hidden border border-white/10 hover:border-red-500/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/20">
                        
                        <!-- Фото мастера -->
                        <div class="relative h-80 overflow-hidden bg-gradient-to-br from-zinc-800 to-zinc-900">
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
                                <div class="w-full h-full flex items-center justify-center text-9xl bg-gradient-to-br from-zinc-800 to-zinc-900">
                                    @switch($loop->index % 5)
                                        @case(0) 👨‍🦰 @break
                                        @case(1) 👨‍🦱 @break
                                        @case(2) 🧔‍♂️ @break
                                        @case(3) 👨‍🦲 @break
                                        @default 💈
                                    @endswitch
                                </div>
                            @endif
                            
                            <!-- Оверлей с кнопкой -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-end pb-6">
                                <a href="{{ route('booking.create') }}?barber={{ $barber->id }}" 
                                   class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-2xl text-sm font-semibold transition-all transform translate-y-4 group-hover:translate-y-0">
                                    Записаться →
                                </a>
                            </div>
                        </div>

                        <!-- Информация о мастере -->
                        <div class="p-6 text-center">
                            <h3 class="text-2xl font-bold mb-1 group-hover:text-red-500 transition-colors">
                                {{ $barber->nickname }}
                            </h3>
                            <p class="text-red-500 text-sm mb-3 font-medium">
                                {{ $barber->specialization ?? 'Master Barber' }}
                            </p>
                            
                            <!-- Рейтинг с реальными данными -->
                            <div class="flex justify-center items-center gap-2 mb-4">
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $fullStars)
                                            <span class="text-yellow-500 text-lg">★</span>
                                        @elseif($hasHalfStar && $i == $fullStars + 1)
                                            <span class="text-yellow-500 text-lg">½</span>
                                        @else
                                            <span class="text-zinc-600 text-lg">★</span>
                                        @endif
                                    @endfor
                                </div>
                                @if($reviewsCount > 0)
                                    <span class="text-xs text-zinc-500">({{ $reviewsCount }} {{ trans_choice('отзыв|отзыва|отзывов', $reviewsCount) }})</span>
                                @else
                                    <span class="text-xs text-zinc-500">(нет отзывов)</span>
                                @endif
                            </div>
                            
                            <!-- Краткое описание -->
                            <p class="text-zinc-400 text-sm leading-relaxed line-clamp-2 mb-4">
                                {{ $barber->description ?? 'Профессиональный барбер с опытом работы. Специализируется на современных стрижках и уходе за бородой.' }}
                            </p>
                            
                            <!-- Ссылка на детальную страницу -->
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
        </div>
    </section>

    <!-- Блок с преимуществами работы с нашими мастерами -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Почему выбирают наших мастеров?</h2>
                <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-red-500/30 transition-all">
                    <div class="text-4xl mb-4">🎓</div>
                    <h3 class="font-bold text-lg mb-2">Постоянное обучение</h3>
                    <p class="text-sm text-zinc-500">Регулярные курсы и мастер-классы от топовых барберов</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-red-500/30 transition-all">
                    <div class="text-4xl mb-4">🔧</div>
                    <h3 class="font-bold text-lg mb-2">Профессиональный инструмент</h3>
                    <p class="text-sm text-zinc-500">Работаем только с проверенным оборудованием</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-red-500/30 transition-all">
                    <div class="text-4xl mb-4">💬</div>
                    <h3 class="font-bold text-lg mb-2">Индивидуальный подход</h3>
                    <p class="text-sm text-zinc-500">Учитываем все пожелания и особенности клиента</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA блок -->
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto text-center bg-gradient-to-br from-red-600/10 to-transparent rounded-3xl p-12 border border-red-500/20">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Не можете определиться с мастером?</h2>
            <p class="text-zinc-400 mb-8 text-lg">Наши администраторы помогут выбрать идеального специалиста под ваш запрос</p>
            <a href="{{ route('booking.create') }}" 
               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 px-8 py-4 rounded-2xl font-semibold transition-all hover:scale-105">
                <span>Записаться на консультацию</span>
                <span>→</span>
            </a>
        </div>
    </section>
</div>

<!-- Дополнительные CSS анимации -->
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
    
    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection