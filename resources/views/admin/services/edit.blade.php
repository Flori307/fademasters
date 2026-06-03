@extends('layouts.app')

@section('title', 'Редактировать услугу')

@section('content')
<div class="bg-zinc-950 py-12 px-6">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold mb-8">Редактировать услугу: {{ $service->name }}</h1>

        <form method="POST" action="{{ route('admin.services.update', $service) }}" 
              enctype="multipart/form-data" class="bg-zinc-900 rounded-3xl p-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Название услуги</label>
                    <input type="text" name="name" value="{{ $service->name }}" required
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Длительность (минут)</label>
                    <input type="number" name="duration_minutes" value="{{ $service->duration_minutes }}" required
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Цена (₽)</label>
                    <input type="number" name="price" value="{{ $service->price }}" required
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Категория</label>
                    <input type="text" name="category" value="{{ $service->category }}" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Описание</label>
                    <textarea name="description" rows="5" 
                              class="w-full bg-zinc-800 border border-zinc-700 rounded-3xl px-6 py-5">{{ $service->description }}</textarea>
                </div>

                <!-- Фото -->
                <div class="md:col-span-2">
                    <label class="block text-sm text-zinc-400 mb-3">Фото услуги</label>
                    @if($service->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 class="w-40 h-40 object-cover rounded-2xl" alt="">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                    <p class="text-xs text-zinc-500 mt-2">Оставьте пустым, если не хотите менять фото</p>
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Порядок сортировки</label>
                    <input type="number" name="sort_order" value="{{ $service->sort_order }}" 
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4">
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-3">
                        <input type="checkbox" name="is_active" value="1" 
                               {{ $service->is_active ? 'checked' : '' }}>
                        <span class="text-zinc-300">Услуга активна и отображается на сайте</span>
                    </label>
                </div>
            </div>

            <div class="mt-12 flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-red-600 hover:bg-red-700 py-5 rounded-2xl font-semibold text-lg">
                    Сохранить изменения
                </button>
                
                <a href="{{ route('admin.services.index') }}" 
                   class="flex-1 text-center border border-zinc-700 hover:bg-zinc-800 py-5 rounded-2xl font-semibold">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection