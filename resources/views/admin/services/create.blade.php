@extends('layouts.app')

@section('title', 'Добавить услугу')

@section('content')
<div class="bg-zinc-950 py-12 px-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Добавить новую услугу</h1>

        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="bg-zinc-900 rounded-3xl p-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Название услуги</label>
                    <input type="text" name="name" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4" required>
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Длительность (минут)</label>
                    <input type="number" name="duration_minutes" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4" required>
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Цена (₽)</label>
                    <input type="number" name="price" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Категория</label>
                    <input type="text" name="category" placeholder="Стрижки, Борода, Комплекс" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Описание</label>
                    <textarea name="description" rows="4" 
                              class="w-full bg-zinc-800 border border-zinc-700 rounded-3xl px-6 py-5"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Фото услуги (необязательно)</label>
                    <input type="file" name="image" accept="image/*" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Порядок сортировки</label>
                    <input type="number" name="sort_order" value="0" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>
            </div>

            <div class="mt-10">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-5 rounded-2xl font-semibold">
                    Создать услугу
                </button>
            </div>
        </form>
    </div>
</div>
@endsection