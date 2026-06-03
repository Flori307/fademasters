@extends('layouts.app')

@section('title', 'Управление отзывами — Админка')

@section('content')
<div class="bg-zinc-950 py-10 px-6 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <div class="inline-block mb-2">
                    <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 text-xs font-medium tracking-wider">
                        ⭐ УПРАВЛЕНИЕ
                    </span>
                </div>
                <h1 class="text-4xl font-bold">
                    <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                        Отзывы
                    </span>
                </h1>
                <p class="text-zinc-400 mt-2">Модерация и управление отзывами клиентов</p>
            </div>
            
            <div class="flex gap-3">
                <div class="bg-amber-600/20 px-4 py-2 rounded-2xl">
                    <span class="text-amber-400 font-semibold">{{ $pendingCount }}</span>
                    <span class="text-zinc-400 text-sm"> на модерации</span>
                </div>
                <div class="bg-green-600/20 px-4 py-2 rounded-2xl">
                    <span class="text-green-400 font-semibold">{{ $reviews->where('is_approved', true)->count() }}</span>
                    <span class="text-zinc-400 text-sm"> опубликовано</span>
                </div>
            </div>
        </div>

        <!-- Фильтры -->
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('admin.reviews.index') }}?filter=all" 
               class="px-5 py-2 rounded-full text-sm font-medium transition-all {{ request('filter') == 'all' || !request('filter') ? 'bg-red-600 text-white' : 'bg-white/5 text-zinc-400 hover:bg-white/10' }}">
                Все отзывы
            </a>
            <a href="{{ route('admin.reviews.index') }}?filter=pending" 
               class="px-5 py-2 rounded-full text-sm font-medium transition-all {{ request('filter') == 'pending' ? 'bg-amber-600 text-white' : 'bg-white/5 text-zinc-400 hover:bg-white/10' }}">
                На модерации
            </a>
            <a href="{{ route('admin.reviews.index') }}?filter=approved" 
               class="px-5 py-2 rounded-full text-sm font-medium transition-all {{ request('filter') == 'approved' ? 'bg-green-600 text-white' : 'bg-white/5 text-zinc-400 hover:bg-white/10' }}">
                Опубликованные
            </a>
        </div>

        <!-- Таблица отзывов -->
        <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl overflow-hidden border border-white/10">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-800/50">
                        <tr>
                            <th class="text-left p-5 text-sm font-medium text-zinc-400">Клиент</th>
                            <th class="text-left p-5 text-sm font-medium text-zinc-400">Мастер</th>
                            <th class="text-center p-5 text-sm font-medium text-zinc-400">Оценка</th>
                            <th class="text-left p-5 text-sm font-medium text-zinc-400">Отзыв</th>
                            <th class="text-center p-5 text-sm font-medium text-zinc-400">Статус</th>
                            <th class="text-right p-5 text-sm font-medium text-zinc-400">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($reviews as $review)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="p-5">
                                <div class="font-medium">{{ $review->user?->name ?? '—' }}</div>
                                <div class="text-xs text-zinc-500">{{ $review->user?->email ?? '' }}</div>
                            </td>
                            <td class="p-5">
                                <div>{{ $review->barber?->nickname ?? '—' }}</div>
                            </td>
                            <td class="p-5 text-center">
                                <div class="flex justify-center gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <span class="text-yellow-500">★</span>
                                        @else
                                            <span class="text-zinc-600">★</span>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td class="p-5 max-w-md">
                                <p class="text-sm text-zinc-300 line-clamp-2">{{ $review->comment }}</p>
                                <div class="text-xs text-zinc-500 mt-1">{{ $review->created_at->format('d.m.Y H:i') }}</div>
                            </td>
                            <td class="p-5 text-center">
                                @if($review->is_approved)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium bg-green-600/20 text-green-400 border border-green-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                        Опубликован
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium bg-amber-600/20 text-amber-400 border border-amber-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        На модерации
                                    </span>
                                @endif
                            </td>
                            <td class="p-5 text-right">
                                <div class="flex justify-end gap-2">
                                    @if(!$review->is_approved)
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-600/20 hover:bg-green-600 text-green-400 hover:text-white px-4 py-2 rounded-xl text-xs font-medium transition-all">
                                                ✅ Одобрить
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white px-4 py-2 rounded-xl text-xs font-medium transition-all" onclick="return confirm('Удалить этот отзыв?')">
                                            🗑️ Удалить
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-16 text-center">
                                <div class="text-6xl mb-4">📭</div>
                                <p class="text-xl text-zinc-400">Нет отзывов</p>
                                <p class="text-sm text-zinc-500 mt-2">Отзывы клиентов появятся здесь</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Пагинация -->
        <div class="mt-8">
            {{ $reviews->withQueryString()->links() }}
        </div>

        <!-- Кнопка назад -->
        <div class="mt-6 text-center">
            <a href="{{ route('admin.dashboard') }}" class="text-zinc-500 hover:text-white transition-colors text-sm">
                ← Вернуться в админ-панель
            </a>
        </div>

    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection