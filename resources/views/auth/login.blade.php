@extends('layouts.app')

@section('title', 'Вход — Fade Masters')

@section('content')
<div class="min-h-screen bg-zinc-950 flex items-center justify-center py-12 px-6">
    <div class="max-w-md w-full">
        <!-- Логотип -->
        <div class="text-center mb-10">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center text-4xl font-black text-white">FM</div>
            </div>
            <h1 class="text-4xl font-black tracking-tighter">FADE MASTERS</h1>
            <p class="text-zinc-400 mt-2">Войдите в свой аккаунт</p>
        </div>

        <div class="bg-zinc-900 rounded-3xl p-10 shadow-2xl border border-zinc-800">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Email адрес</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-zinc-800 border border-zinc-700 focus:border-red-600 rounded-2xl px-6 py-4 text-white placeholder-zinc-500 focus:outline-none transition">
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Пароль -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Пароль</label>
                    <input type="password" name="password" required
                           class="w-full bg-zinc-800 border border-zinc-700 focus:border-red-600 rounded-2xl px-6 py-4 text-white placeholder-zinc-500 focus:outline-none transition">
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Запомнить меня -->
                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center text-sm text-zinc-400">
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-red-600 bg-zinc-800 border-zinc-700">
                        <span class="ml-2">Запомнить меня</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-red-500 hover:text-red-400">
                        Забыли пароль?
                    </a>
                </div>

                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 transition py-5 rounded-2xl font-semibold text-lg">
                    Войти в аккаунт
                </button>
            </form>

            <div class="text-center mt-8 text-zinc-400">
                Нет аккаунта? 
                <a href="{{ route('register') }}" class="text-red-500 hover:text-red-400 font-medium">Зарегистрироваться</a>
            </div>
        </div>
    </div>
</div>
@endsection