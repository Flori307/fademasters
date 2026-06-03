@extends('layouts.app')

@section('title', 'Мастера — Админка')

@section('content')
<div class="bg-zinc-950 py-10 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold">Мастера</h1>
            <a href="{{ route('admin.barbers.create') }}" class="bg-red-600 hover:bg-red-700 px-6 py-4 rounded-2xl font-semibold">
                + Добавить мастера
            </a>
        </div>

        <div class="bg-zinc-900 rounded-3xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="p-6 text-left">Мастер</th>
                        <th class="p-6 text-left">Специализация</th>
                        <th class="p-6 text-center">Опыт</th>
                        <th class="p-6 text-center">Активен</th>
                        <th class="p-6 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach($barbers as $barber)
                    <tr class="hover:bg-zinc-800/50">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                @if($barber->photo)
                                    <img src="{{ asset('storage/' . $barber->photo) }}" 
                                         class="w-12 h-12 rounded-2xl object-cover" alt="">
                                @else
                                    <div class="w-12 h-12 bg-zinc-700 rounded-2xl flex items-center justify-center text-xl">👨‍🦰</div>
                                @endif
                                <div>
                                    <div class="font-semibold">{{ $barber->nickname }}</div>
                                    <div class="text-sm text-zinc-400">{{ $barber->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-zinc-400">{{ $barber->specialization }}</td>
                        <td class="p-6 text-center">{{ $barber->experience_years ?? '-' }} лет</td>
                        <td class="p-6 text-center">
                            <span class="{{ $barber->is_active ? 'text-green-500' : 'text-red-500' }}">
                                {{ $barber->is_active ? '● Активен' : '○ Неактивен' }}
                            </span>
                        </td>
                        <td class="p-6 text-right space-x-4">
                            <a href="{{ route('admin.barbers.edit', $barber) }}" class="text-blue-400 hover:text-blue-300">Изменить</a>
                            <form method="POST" action="{{ route('admin.barbers.destroy', $barber) }}" class="inline" 
                                  onsubmit="return confirm('Удалить мастера?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection