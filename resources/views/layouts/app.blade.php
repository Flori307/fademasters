<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fade Masters — Барбершоп')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-zinc-950 text-zinc-200 font-sans">

    <!-- Navbar -->
    <nav class="bg-black border-b border-zinc-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Логотип -->
        <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition">
            <div class="w-9 h-9 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">FM</div>
            <span class="text-2xl font-bold tracking-tighter hidden sm:inline">FADE MASTERS</span>
        </a>

        <!-- Десктопное меню -->
        <div class="hidden md:flex items-center gap-8 text-sm font-medium">
            <a href="{{ route('home') }}" class="text-zinc-300 hover:text-white transition">Главная</a>
            <a href="{{ route('services.index') }}" class="text-zinc-300 hover:text-white transition">Услуги</a>
            <a href="{{ route('barbers.index') }}" class="text-zinc-300 hover:text-white transition">Мастера</a>
            <a href="{{ route('booking.create') }}" class="text-zinc-300 hover:text-white transition">Записаться</a>
            <a href="{{ route('about') }}" class="text-zinc-300 hover:text-white transition">О нас</a>
        </div>

        <!-- Правая часть: авторизация -->
        <div class="flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="text-sm text-zinc-300 hover:text-white transition">Войти</a>
                <a href="{{ route('register') }}" 
                   class="bg-red-600 hover:bg-red-700 px-5 py-2 rounded-xl text-sm font-semibold transition">
                    Регистрация
                </a>
            @else
                <a href="{{ route('profile.appointments') }}" class="text-sm text-zinc-300 hover:text-white transition">Мои записи</a>
                
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-zinc-800 hover:bg-zinc-700 px-4 py-2 rounded-xl text-sm transition">
                        Админка
                    </a>
                @elseif(auth()->user()->hasRole('barber'))
                    <a href="{{ route('barber.dashboard') }}" 
                       class="bg-zinc-800 hover:bg-zinc-700 px-4 py-2 rounded-xl text-sm transition">
                        Панель
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}" class="text-sm text-zinc-300 hover:text-white transition">Профиль</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-zinc-300 hover:text-red-500 transition">Выйти</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

    <!-- Основной контент -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t border-zinc-800 py-16">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">FM</div>
                    <span class="text-2xl font-bold tracking-tighter">FADE MASTERS</span>
                </div>
                <p class="text-zinc-500">Премиальный мужской барбершоп в Москве.<br>Стиль, который держится.</p>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Навигация</h4>
                <ul class="space-y-2 text-zinc-400">
                    <li><a href="{{ route('services.index') }}" class="hover:text-white">Услуги и цены</a></li>
                    <li><a href="{{ route('barbers.index') }}" class="hover:text-white">Наши мастера</a></li>
                    <li><a href="{{ route('booking.create') }}" class="hover:text-white">Онлайн-запись</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-4">Контакты</h4>
                <ul class="space-y-2 text-zinc-400">
                    <li>📍 Челябинск, ул. Набережная, 52</li>
                    <li>☎ +7 (999) 123-45-67</li>
                    <li>✉ info@fademasters.ru</li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-4">Мы в соцсетях</h4>
                <div class="flex gap-4 text-2xl">
                    <a href="#" class="hover:text-red-500"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-red-500"><i class="fab fa-vk"></i></a>
                </div>
            </div>
        </div>
        
        <div class="text-center text-zinc-600 text-sm mt-16">
            © 2026 Fade Masters
        </div>
    </footer>

</body>
</html>