@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('title', $barber->nickname . ' — Fade Masters')

@section('content')
<div class="bg-zinc-950 text-zinc-200">

    <!-- Hero Section -->
    <section class="relative min-h-[80vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-black via-zinc-900/90 to-black"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                
                <!-- Фото мастера -->
                <div class="order-2 md:order-1">
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-gradient-to-r from-red-600 to-red-800 rounded-[3rem] opacity-20 group-hover:opacity-40 blur-xl transition-all duration-500"></div>
                        <div class="absolute -inset-2 bg-gradient-to-r from-red-600 to-red-800 rounded-[3rem] opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                        
                        <div class="relative rounded-3xl overflow-hidden border-4 border-white/10 shadow-2xl">
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
                                     class="w-full h-[500px] object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-[500px] flex items-center justify-center text-9xl bg-gradient-to-br from-zinc-800 to-zinc-900">
                                    👨‍🦰
                                </div>
                            @endif
                        </div>
                        
                        @if($barber->experience_years)
                        <div class="absolute -bottom-4 -right-4 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl px-6 py-3 shadow-lg">
                            <div class="text-2xl font-bold">{{ $barber->experience_years }}</div>
                            <div class="text-xs opacity-90">лет опыта</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Информация о мастере -->
                <div class="order-1 md:order-2 space-y-6">
                    <div class="inline-block">
                        <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 text-xs font-medium tracking-wider">
                            MASTER BARBER
                        </span>
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-black tracking-tighter leading-none">
                        <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                            {{ $barber->nickname }}
                        </span>
                    </h1>
                    
                    <p class="text-xl text-red-500 font-medium">{{ $barber->specialization ?? 'Professional Barber' }}</p>
                    
                    <!-- Рейтинг -->
                    @php
                        $approvedReviews = $barber->reviews()->where('is_approved', true)->get();
                        $avgRating = round($approvedReviews->avg('rating') ?? 0);
                        $reviewsCount = $approvedReviews->count();
                    @endphp
                    <div class="flex items-center gap-3">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $avgRating)
                                    <span class="text-yellow-500 text-xl">★</span>
                                @else
                                    <span class="text-zinc-600 text-xl">★</span>
                                @endif
                            @endfor
                        </div>
                        @if($reviewsCount > 0)
                            <span class="text-sm text-zinc-400">({{ $reviewsCount }} {{ trans_choice('отзыв|отзыва|отзывов', $reviewsCount) }})</span>
                        @else
                            <span class="text-sm text-zinc-500">(нет отзывов)</span>
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('booking.create') }}?barber={{ $barber->id }}" 
                           class="group relative bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 px-8 py-4 rounded-2xl text-lg font-semibold transition-all hover:scale-105 overflow-hidden">
                            <span class="relative z-10">Записаться к мастеру</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        </a>
                        <a href="#services" 
                           class="border-2 border-white/30 hover:border-red-500 hover:bg-red-500/10 px-8 py-4 rounded-2xl text-lg font-semibold transition-all">
                            Услуги мастера
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Основная информация -->
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Левая колонка: О мастере -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-1 bg-red-600 rounded-full"></div>
                    <h2 class="text-3xl font-bold">О мастере</h2>
                </div>
                <div class="text-lg leading-relaxed text-zinc-300 space-y-4">
                    {!! nl2br(e($barber->description ?? 'Профессиональный барбер с большим опытом работы. Специализируется на современных стрижках и уходе за бородой. Индивидуальный подход к каждому клиенту и использование только премиум-средств.')) !!}
                </div>
                
                <!-- Ключевые навыки -->
                <div class="mt-10">
                    <h3 class="text-xl font-semibold mb-4">Ключевые навыки</h3>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $skills = explode(',', $barber->specialization ?? 'Fade,Стрижка бороды,Моделирование');
                        @endphp
                        @foreach($skills as $skill)
                        <span class="bg-white/5 border border-white/10 rounded-full px-4 py-2 text-sm">
                            {{ trim($skill) }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Правая колонка: Услуги и график -->
            <div class="lg:col-span-1" id="services">
                <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl p-6 sticky top-24 border border-white/10">
                    
                    <!-- Услуги -->
                    <h3 class="text-xl font-semibold mb-5">Услуги мастера</h3>
                    
                    @if($barber->services->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($barber->services as $service)
                        <div class="flex justify-between items-center py-3 border-b border-white/10">
                            <div>
                                <div class="font-medium">{{ $service->name }}</div>
                                <div class="text-xs text-zinc-500">{{ $service->duration_minutes }} мин</div>
                            </div>
                            <div class="text-xl font-bold text-white">
                                {{ number_format($service->price, 0, ' ', ' ') }} ₽
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <div class="text-center py-8 text-zinc-400">
                            <p>Список услуг обновляется...</p>
                        </div>
                    @endif

                    <!-- График работы -->
                    <div class="mt-6 pt-6 border-t border-white/10">
                        <h4 class="font-semibold mb-3">График работы</h4>
                        <div class="space-y-2">
                            @php
                                $days = ['monday' => 'ПН', 'tuesday' => 'ВТ', 'wednesday' => 'СР', 'thursday' => 'ЧТ', 'friday' => 'ПТ', 'saturday' => 'СБ', 'sunday' => 'ВС'];
                                $workingDays = $barber->working_days ?? ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                            @endphp
                            @foreach($days as $key => $name)
                            <div class="flex justify-between py-1.5">
                                <span class="{{ in_array($key, $workingDays) ? 'text-white' : 'text-zinc-600' }}">
                                    {{ $name }}
                                </span>
                                <span class="text-sm {{ in_array($key, $workingDays) ? 'text-green-500' : 'text-zinc-600' }}">
                                    @if(in_array($key, $workingDays))
                                        {{ \Carbon\Carbon::parse($barber->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($barber->end_time)->format('H:i') }}
                                    @else
                                        Выходной
                                    @endif
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('booking.create') }}?barber={{ $barber->id }}" 
                       class="mt-6 block w-full text-center bg-red-600 hover:bg-red-700 py-4 rounded-2xl font-semibold transition-all">
                        Записаться
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок отзывов -->
    <section class="py-20 px-6 bg-gradient-to-b from-transparent to-zinc-900/30">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <div class="inline-block mb-4">
                    <span class="text-red-500 font-semibold tracking-wider">ОТЗЫВЫ</span>
                </div>
                <h2 class="text-4xl font-bold mb-4">Что говорят клиенты</h2>
                
                @php
                    $avgRatingFull = round($approvedReviews->avg('rating') ?? 0);
                @endphp
                <div class="flex items-center justify-center gap-3">
                    <div class="flex gap-1 text-2xl">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avgRatingFull)
                                <span class="text-yellow-500">★</span>
                            @else
                                <span class="text-zinc-600">★</span>
                            @endif
                        @endfor
                    </div>
                    <span class="text-zinc-400">({{ $reviewsCount }} {{ trans_choice('отзыв|отзыва|отзывов', $reviewsCount) }})</span>
                </div>
            </div>

            <!-- Кнопка добавить отзыв -->
            @auth
                @php
                    $hasCompletedAppointment = \App\Models\Appointment::where('user_id', Auth::id())
                        ->where('barber_id', $barber->id)
                        ->where('status', 'completed')
                        ->exists();
                    $hasReview = \App\Models\Review::where('user_id', Auth::id())
                        ->where('barber_id', $barber->id)
                        ->exists();
                @endphp
                
                @if($hasCompletedAppointment && !$hasReview)
                    <div class="text-center mb-10">
                        <a href="{{ route('reviews.create', $barber) }}" 
                           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 px-6 py-3 rounded-2xl font-semibold transition-all">
                            <span>✍️</span>
                            <span>Оставить отзыв</span>
                        </a>
                    </div>
                @endif
            @endauth

            <!-- Список одобренных отзывов -->
            @if($approvedReviews->isNotEmpty())
                <div class="space-y-5">
                    @foreach($approvedReviews as $review)
                    <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-2xl p-6 border border-white/10 hover:border-red-500/20 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="font-semibold">{{ $review->user->name ?? 'Анонимный клиент' }}</p>
                                    <div class="flex gap-0.5 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <span class="text-yellow-500">★</span>
                                            @else
                                                <span class="text-zinc-600">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-zinc-500">
                                {{ $review->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                        <p class="text-zinc-300 leading-relaxed">
                            {{ $review->comment }}
                        </p>
                        
                        @auth
                            @if(Auth::user()->hasRole('admin') || Auth::id() === $review->user_id)
                            <div class="mt-4 text-right">
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors" onclick="return confirm('Удалить отзыв?')">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                            @endif
                        @endauth
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white/5 rounded-3xl border border-white/10">
                    <div class="text-5xl mb-4">📝</div>
                    <p class="text-zinc-400">Пока нет отзывов</p>
                    @auth
                        @if($hasCompletedAppointment ?? false)
                            <p class="text-sm text-zinc-500 mt-2">Будьте первым, кто оценит работу мастера</p>
                        @else
                            <p class="text-sm text-zinc-500 mt-2">Отзывы появятся после посещения мастера</p>
                        @endif
                    @else
                        <p class="text-sm text-zinc-500 mt-2">Войдите в аккаунт, чтобы оставить отзыв</p>
                    @endauth
                </div>
            @endif
        </div>
    </section>

</div>
@endsection