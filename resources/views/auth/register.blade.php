@extends('layouts.app')

@section('title', 'Регистрация — Fade Masters')

@section('content')
<div class="min-h-screen bg-zinc-950 flex items-center justify-center py-12 px-6">
    <div class="max-w-md w-full">
        <!-- Логотип + Заголовок -->
        <div class="text-center mb-10">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center text-4xl font-black text-white">FM</div>
            </div>
            <h1 class="text-4xl font-black tracking-tighter">FADE MASTERS</h1>
            <p class="text-zinc-400 mt-2">Создайте аккаунт и записывайтесь онлайн</p>
        </div>

        <div class="bg-zinc-900 rounded-3xl p-10 shadow-2xl border border-zinc-800">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Имя -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Ваше имя</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-zinc-800 border border-zinc-700 focus:border-red-600 rounded-2xl px-6 py-4 text-white placeholder-zinc-500 focus:outline-none transition">
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Email адрес</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-zinc-800 border border-zinc-700 focus:border-red-600 rounded-2xl px-6 py-4 text-white placeholder-zinc-500 focus:outline-none transition">
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Телефон -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Номер телефона</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required
                           placeholder="+7 (999) 123-45-67"
                           class="w-full bg-zinc-800 border border-zinc-700 focus:border-red-600 rounded-2xl px-6 py-4 text-white placeholder-zinc-500 focus:outline-none transition">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Пароль -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Пароль</label>
                    <input type="password" name="password" required
                           class="w-full bg-zinc-800 border border-zinc-700 focus:border-red-600 rounded-2xl px-6 py-4 text-white placeholder-zinc-500 focus:outline-none transition">
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Подтверждение пароля -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Подтвердите пароль</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full bg-zinc-800 border border-zinc-700 focus:border-red-600 rounded-2xl px-6 py-4 text-white placeholder-zinc-500 focus:outline-none transition">
                </div>

                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 transition py-5 rounded-2xl font-semibold text-lg">
                    Создать аккаунт
                </button>
            </form>

            <div class="text-center mt-8 text-zinc-400">
                Уже есть аккаунт? 
                <a href="{{ route('login') }}" class="text-red-500 hover:text-red-400 font-medium">Войти</a>
            </div>
        </div>

        <p class="text-center text-xs text-zinc-600 mt-8">
            Регистрируясь, вы соглашаетесь с политикой конфиденциальности
        </p>
    </div>
</div>

<script>
document.getElementById('avatar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    // Проверка размера (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Файл слишком большой! Максимум 2 МБ.');
        this.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(event) {
        const preview = document.getElementById('avatar-preview');
        preview.innerHTML = `<img src="${event.target.result}" alt="Preview" class="w-full h-full object-cover rounded-2xl">`;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection