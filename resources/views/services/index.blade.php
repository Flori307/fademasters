@extends('layouts.app')

@section('title', 'Услуги — Fade Masters')

@section('content')
<div class="bg-zinc-950">
    
    <!-- Hero секция с градиентом -->
    <section class="relative pt-32 pb-20 px-6 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-red-900/20 via-transparent to-transparent"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto text-center">
            <div class="inline-block mb-6 animate-fade-down">
                <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-6 py-2 text-sm font-medium tracking-wider">
                    💈 НАШИ УСЛУГИ
                </span>
            </div>
            <h1 class="text-6xl md:text-8xl font-black tracking-tighter mb-6 animate-fade-up">
                <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                    Услуги
                </span>
                <br>
                <span class="text-white">и цены</span>
            </h1>
            <p class="text-xl md:text-2xl text-zinc-400 max-w-3xl mx-auto animate-fade-up animation-delay-200">
                Профессиональный уход за волосами и бородой с использованием премиум средств
            </p>
            
            <!-- Фильтры категорий -->
            <div class="flex flex-wrap justify-center gap-3 mt-12 animate-fade-up animation-delay-400">
                <button class="filter-btn active px-6 py-2 rounded-full bg-red-600 text-white text-sm font-medium transition-all" data-category="all">
                    Все услуги
                </button>
                @php
                    $categories = $services->pluck('category')->unique()->filter();
                @endphp
                @foreach($categories as $category)
                    @if($category)
                    <button class="filter-btn px-6 py-2 rounded-full bg-white/5 hover:bg-white/10 text-zinc-300 text-sm font-medium transition-all" data-category="{{ Str::slug($category) }}">
                        {{ $category }}
                    </button>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Сетка услуг -->
    <section class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="service-card group relative bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl overflow-hidden border border-white/10 hover:border-red-500/50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/20"
                     data-category="{{ Str::slug($service->category) }}">
                    
                    <!-- Фоновый паттерн -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-red-600/10 rounded-full blur-3xl"></div>
                    </div>
                    

                    <div class="relative h-56 bg-gradient-to-br from-zinc-800/50 to-zinc-900/50 flex items-center justify-center overflow-hidden">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                alt="{{ $service->name }}"
                                class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110">
                        @else
                            <!-- fallback иконка если фото нет -->
                            <div class="text-8xl transition-all duration-500 group-hover:scale-110 group-hover:rotate-6">
                                @php
                                    $icons = [
                                        'стрижка' => '✂️',
                                        'борода' => '🧔',
                                        'бритва' => '🪒',
                                        'уход' => '💆',
                                        'камуфляж' => '🎨',
                                        'комплекс' => '✨',
                                        'default' => '💈'
                                    ];
                                    $icon = 'default';
                                    foreach($icons as $key => $value) {
                                        if(str_contains(strtolower($service->name), $key) || str_contains(strtolower($service->category ?? ''), $key)) {
                                            $icon = $value;
                                            break;
                                        }
                                    }
                                @endphp
                                {{ $icon }}
                            </div>
                        @endif
                        
                        <!-- Бейдж популярности -->
                        @if($loop->index < 3)
                        <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                            🔥 Популярное
                        </div>
                        @endif
                    </div>
                    
                    <div class="relative p-8">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold tracking-tight group-hover:text-red-500 transition-colors">
                                    {{ $service->name }}
                                </h3>
                                @if($service->category)
                                <span class="inline-block text-xs text-zinc-500 mt-2 px-3 py-1 rounded-full bg-white/5">
                                    {{ $service->category }}
                                </span>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-black text-white">
                                    {{ number_format($service->price, 0, ' ', ' ') }}
                                </div>
                                <div class="text-xs text-zinc-500">₽</div>
                            </div>
                        </div>

                        <p class="text-zinc-400 leading-relaxed mb-6 line-clamp-2 text-sm">
                            {{ $service->description ?? 'Профессиональная услуга с индивидуальным подходом и качественными средствами.' }}
                        </p>

                        <!-- Детали услуги -->
                        <div class="flex items-center gap-4 mb-6 text-sm">
                            <div class="flex items-center gap-2 text-zinc-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $service->duration_minutes }} мин</span>
                            </div>
                            <div class="flex items-center gap-2 text-zinc-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Качественно</span>
                            </div>
                        </div>

                        <!-- Кнопка записи -->
                        <a href="{{ route('booking.create') }}?service={{ $service->id }}" 
                           class="group/btn relative w-full flex items-center justify-center gap-3 bg-red-600 hover:bg-red-700 px-6 py-4 rounded-2xl text-sm font-semibold transition-all overflow-hidden">
                            <span class="relative z-10">Записаться</span>
                            <svg class="relative z-10 w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000"></div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Блок с преимуществами услуг -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10">
                    <div class="text-3xl mb-3">💎</div>
                    <p class="font-semibold">Премиум средства</p>
                    <p class="text-sm text-zinc-500">American Crew, Reuzel</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10">
                    <div class="text-3xl mb-3">🧼</div>
                    <p class="font-semibold">Стерильность</p>
                    <p class="text-sm text-zinc-500">Одноразовые расходники</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10">
                    <div class="text-3xl mb-3">📋</div>
                    <p class="font-semibold">Гарантия результата</p>
                    <p class="text-sm text-zinc-500">Бесплатная коррекция</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10">
                    <div class="text-3xl mb-3">☕</div>
                    <p class="font-semibold">Бесплатный кофе</p>
                    <p class="text-sm text-zinc-500">Во время ожидания</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA блок -->
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto text-center bg-gradient-to-br from-red-600/10 to-transparent rounded-3xl p-12 border border-red-500/20">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Не нашли подходящую услугу?</h2>
            <p class="text-zinc-400 mb-8 text-lg">Напишите нам — подберём индивидуальный вариант специально для вас</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+79991234567" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 px-8 py-4 rounded-2xl font-semibold transition-all">
                    📞 +7 (999) 123-45-67
                </a>
                <a href="https://wa.me/79991234567" target="_blank" class="inline-flex items-center justify-center gap-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 px-8 py-4 rounded-2xl font-semibold transition-all">
                    💬 Написать в VK
                </a>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript для фильтрации -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.service-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Убираем активный класс у всех кнопок
            filterBtns.forEach(b => {
                b.classList.remove('active', 'bg-red-600', 'text-white');
                b.classList.add('bg-white/5', 'text-zinc-300');
            });
            
            // Добавляем активный класс нажатой кнопке
            this.classList.add('active', 'bg-red-600', 'text-white');
            this.classList.remove('bg-white/5', 'text-zinc-300');
            
            const category = this.dataset.category;
            
            cards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
});
</script>

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
    
    .service-card {
        transition: all 0.3s ease;
    }
    
    .service-card {
        display: block;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection