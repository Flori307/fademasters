@extends('layouts.app')

@section('title', 'Оставить отзыв — ' . $barber->nickname)

@section('content')
<div class="bg-zinc-950 min-h-screen py-20 px-6">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-10">
            <div class="inline-block mb-4">
                <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium tracking-wider">
                    📝 ОСТАВИТЬ ОТЗЫВ
                </span>
            </div>
            <h1 class="text-4xl font-bold mb-2">
                Мастер: {{ $barber->nickname }}
            </h1>
            <p class="text-zinc-400">Поделитесь впечатлениями о работе мастера</p>
        </div>

        <form method="POST" action="{{ route('reviews.store', $barber) }}" class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl p-8 border border-white/10">
            @csrf

            <!-- Выбор записи (если их несколько) -->
            @if($completedAppointments->count() > 1)
            <div class="mb-6">
                <label class="block text-sm font-medium text-zinc-400 mb-3">
                    📅 Выберите визит
                </label>
                <select name="appointment_id" required 
                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none">
                    @foreach($completedAppointments as $appointment)
                    <option value="{{ $appointment->id }}">
                        {{ $appointment->appointment_date->format('d.m.Y') }} — {{ $appointment->start_time }} ({{ $appointment->service->name }})
                    </option>
                    @endforeach
                </select>
            </div>
            @else
                <input type="hidden" name="appointment_id" value="{{ $completedAppointments->first()->id ?? '' }}">
            @endif

            <!-- Рейтинг звездами -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-zinc-400 mb-4 text-center">
                    Ваша оценка
                </label>
                <div class="flex justify-center gap-2">
                    <div class="star-rating flex gap-3 text-5xl cursor-pointer">
                        <span class="star" data-value="1">☆</span>
                        <span class="star" data-value="2">☆</span>
                        <span class="star" data-value="3">☆</span>
                        <span class="star" data-value="4">☆</span>
                        <span class="star" data-value="5">☆</span>
                    </div>
                </div>
                <input type="hidden" name="rating" id="rating" value="" required>
                @error('rating')
                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- Текст отзыва -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-zinc-400 mb-3">
                    Ваш отзыв
                </label>
                <textarea name="comment" rows="6" 
                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none transition-all resize-none"
                    placeholder="Расскажите о качестве стрижки, атмосфере, отношении мастера..."></textarea>
                @error('comment')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Кнопки -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 py-4 rounded-2xl font-semibold transition-all">
                    📤 Отправить отзыв
                </button>
                <a href="{{ route('barbers.show', $barber) }}" 
                   class="flex-1 text-center border border-white/20 hover:bg-white/5 py-4 rounded-2xl font-semibold transition-all">
                    Отмена
                </a>
            </div>

            <p class="text-xs text-zinc-500 text-center mt-6">
                Отзывы проходят модерацию перед публикацией
            </p>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            ratingInput.value = value;
            
            stars.forEach((s, index) => {
                if (index < value) {
                    s.textContent = '★';
                    s.classList.add('text-yellow-500');
                } else {
                    s.textContent = '☆';
                    s.classList.remove('text-yellow-500');
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            stars.forEach((s, index) => {
                if (index < value) {
                    s.textContent = '★';
                } else {
                    s.textContent = '☆';
                }
            });
        });
    });
    
    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingInput.value);
        stars.forEach((s, index) => {
            if (currentRating && index < currentRating) {
                s.textContent = '★';
                s.classList.add('text-yellow-500');
            } else {
                s.textContent = '☆';
                s.classList.remove('text-yellow-500');
            }
        });
    });
});
</script>
@endsection