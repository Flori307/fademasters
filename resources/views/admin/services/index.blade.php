@extends('layouts.app')

@section('title', 'Услуги — Админка')

@section('content')
<div class="bg-zinc-950 py-10 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold">Услуги</h1>
            <a href="{{ route('admin.services.create') }}" class="bg-red-600 hover:bg-red-700 px-6 py-4 rounded-2xl font-semibold">
                + Добавить услугу
            </a>
        </div>

        <div class="bg-zinc-900 rounded-3xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="text-left p-6">Название</th>
                        <th class="text-left p-6">Категория</th>
                        <th class="text-center p-6">Длительность</th>
                        <th class="text-right p-6">Цена</th>
                        <th class="text-center p-6">Активна</th>
                        <th class="text-right p-6">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach($services as $service)
                    <tr class="hover:bg-zinc-800/50">
                        <td class="p-6 font-medium">{{ $service->name }}</td>
                        <td class="p-6 text-zinc-400">{{ $service->category }}</td>
                        <td class="p-6 text-center">{{ $service->duration_minutes }} мин</td>
                        <td class="p-6 text-right font-bold">{{ number_format($service->price) }} ₽</td>
                        <td class="p-6 text-center">
                            <span class="{{ $service->is_active ? 'text-green-500' : 'text-red-500' }}">
                                {{ $service->is_active ? '●' : '○' }}
                            </span>
                        </td>
                        <td class="p-6 text-right space-x-4">
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-500 hover:text-blue-400">Изменить</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline" 
                                  onsubmit="return confirm('Удалить услугу?')">
                                @csrf @method('DELETE')
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