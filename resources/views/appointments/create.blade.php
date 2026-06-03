@extends('layouts.app')

@section('title', 'Онлайн-запись — Fade Masters')

@section('content')
<div class="bg-zinc-950 min-h-screen">
    
    <!-- Hero секция -->
    <section class="relative pt-20 pb-12 px-6 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-red-900/10 via-transparent to-transparent"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-2xl mx-auto text-center">
            <div class="inline-block mb-4">
                <span class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium tracking-wider">
                    📅 ЗАПИСЬ ОНЛАЙН
                </span>
            </div>
            <h1 class="text-5xl md:text-6xl font-black tracking-tighter mb-4">
                <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">
                    Онлайн-запись
                </span>
            </h1>
            <p class="text-xl text-zinc-400">
                Выберите мастера, услугу и свободное время
            </p>
        </div>
    </section>

    <!-- Форма записи -->
    <section class="py-8 px-6 pb-20">
        <div class="max-w-2xl mx-auto">
            <form id="booking-form" method="POST" action="{{ route('booking.store') }}" class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-3xl p-8 md:p-10 border border-white/10 shadow-2xl">
                @csrf

                <!-- Шаги записи (визуальный индикатор) -->
                <div class="flex justify-between mb-10">
                    <div class="flex-1 text-center relative">
                        <div class="step-indicator active w-10 h-10 mx-auto rounded-full bg-red-600 flex items-center justify-center text-white font-bold mb-2 relative z-10">1</div>
                        <div class="text-xs text-zinc-400">Мастер</div>
                    </div>
                    <div class="flex-1 text-center relative">
                        <div class="step-indicator w-10 h-10 mx-auto rounded-full bg-zinc-700 flex items-center justify-center text-white font-bold mb-2 relative z-10">2</div>
                        <div class="text-xs text-zinc-400">Услуга</div>
                    </div>
                    <div class="flex-1 text-center relative">
                        <div class="step-indicator w-10 h-10 mx-auto rounded-full bg-zinc-700 flex items-center justify-center text-white font-bold mb-2 relative z-10">3</div>
                        <div class="text-xs text-zinc-400">Дата и время</div>
                    </div>
                    <div class="flex-1 text-center relative">
                        <div class="step-indicator w-10 h-10 mx-auto rounded-full bg-zinc-700 flex items-center justify-center text-white font-bold mb-2 relative z-10">4</div>
                        <div class="text-xs text-zinc-400">Подтверждение</div>
                    </div>
                </div>

                <!-- Мастер (первый) -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-zinc-400 mb-3 flex items-center gap-2">
                        <span>👨‍🦰</span> Выберите мастера
                    </label>
                    <div class="relative">
                        <select id="barber_id" name="barber_id" required 
                                class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none transition-all appearance-none">
                            <option value="">— Выберите мастера —</option>
                            @foreach($barbers as $barber)
                            <option value="{{ $barber->id }}" data-photo="{{ $barber->photo }}">
                                {{ $barber->nickname }} — {{ $barber->specialization ?? 'Barber' }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Услуга (второй) -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-zinc-400 mb-3 flex items-center gap-2">
                        <span>💈</span> Выберите услугу
                    </label>
                    <select id="service_id" name="service_id" required 
                            class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none transition-all">
                        <option value="">— Сначала выберите мастера —</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}" data-duration="{{ $service->duration_minutes }}" data-price="{{ $service->price }}" style="display: none;">
                            {{ $service->name }} — {{ number_format($service->price) }} ₽ ({{ $service->duration_minutes }} мин)
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Дата -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-zinc-400 mb-3 flex items-center gap-2">
                        <span>📅</span> Выберите дату
                    </label>
                    <input type="date" id="appointment_date" name="appointment_date" 
                           value="{{ now()->format('Y-m-d') }}"
                           min="{{ now()->format('Y-m-d') }}"
                           class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none transition-all">
                </div>

                <!-- Свободное время -->
                <div class="mb-10">
                    <label class="block text-sm font-medium text-zinc-400 mb-3 flex items-center gap-2">
                        <span>⏰</span> Доступное время
                    </label>
                    <div id="time-slots" class="grid grid-cols-3 sm:grid-cols-4 gap-3 min-h-[200px]">
                        <div class="col-span-full text-center py-10 text-zinc-500">
                            Выберите мастера, услугу и дату
                        </div>
                    </div>
                    <input type="hidden" id="start_time" name="start_time" required>
                </div>

                <!-- Краткая информация о выбранном -->
                <div id="selected-info" class="mb-8 p-4 rounded-2xl bg-white/5 border border-white/10 hidden">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-zinc-400">Вы выбрали:</p>
                            <p id="selected-summary" class="font-semibold"></p>
                        </div>
                        <div id="selected-price" class="text-2xl font-bold text-red-500"></div>
                    </div>
                </div>

                <!-- Пожелания -->
                <div class="mb-10">
                    <label class="block text-sm font-medium text-zinc-400 mb-3 flex items-center gap-2">
                        <span>💭</span> Пожелания / комментарий
                    </label>
                    <textarea name="notes" rows="3" 
                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-2xl px-6 py-4 text-white focus:border-red-500 focus:outline-none transition-all resize-none"
                        placeholder="Например: сделать fade 0 на висках, уточнить детали стрижки..."></textarea>
                </div>

                <button type="submit" id="submit-btn"
                        class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 py-5 rounded-2xl text-lg font-semibold transition-all hover:scale-[1.02] disabled:opacity-50 disabled:hover:scale-100"
                        disabled>
                    <span class="flex items-center justify-center gap-2">
                        <span>Подтвердить запись</span>
                        <span>→</span>
                    </span>
                </button>

                <p class="text-xs text-zinc-500 text-center mt-6">
                    После подтверждения записи вы получите уведомление на email и в личный кабинет
                </p>
            </form>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const serviceSelect = document.getElementById('service_id');
    const barberSelect = document.getElementById('barber_id');
    const dateInput = document.getElementById('appointment_date');
    const timeSlotsDiv = document.getElementById('time-slots');
    const startTimeInput = document.getElementById('start_time');
    const submitBtn = document.getElementById('submit-btn');
    const selectedInfoDiv = document.getElementById('selected-info');
    const selectedSummary = document.getElementById('selected-summary');
    const selectedPrice = document.getElementById('selected-price');
    const steps = document.querySelectorAll('.step-indicator');

    /**
     * Обновление шагов
     */
    function updateSteps() {
        const hasBarber = !!barberSelect.value;
        const hasService = !!serviceSelect.value;
        const hasTime = !!startTimeInput.value;

        steps.forEach((step, index) => {
            step.classList.remove('bg-red-600');
            step.classList.add('bg-zinc-700');

            if (
                (index === 0 && hasBarber) ||
                (index === 1 && hasService) ||
                (index === 2 && hasTime) ||
                (index === 3 && hasTime)
            ) {
                step.classList.remove('bg-zinc-700');
                step.classList.add('bg-red-600');
            }
        });
    }

    /**
     * Информация о выбранном
     */
    function updateSelectedInfo() {
        const serviceId = serviceSelect.value;
        const barberId = barberSelect.value;

        if (!serviceId || !barberId) {
            selectedInfoDiv.classList.add('hidden');
            return;
        }

        const serviceOption = serviceSelect.options[serviceSelect.selectedIndex];
        const barberOption = barberSelect.options[barberSelect.selectedIndex];
        const serviceName = serviceOption.text.split(' —')[0];
        const barberName = barberOption.text.split(' —')[0];
        const price = serviceOption.dataset.price;

        selectedSummary.innerHTML = `${serviceName} • Мастер ${barberName}`;
        selectedPrice.innerHTML = `${Number(price).toLocaleString('ru-RU')} ₽`;
        selectedInfoDiv.classList.remove('hidden');
    }

    /**
     * Фильтрация услуг по выбранному мастеру
     */
    function filterServicesByBarber() {
        const barberId = barberSelect.value;

        // Скрываем все услуги
        Array.from(serviceSelect.options).forEach(option => {
            if (option.value) {
                option.style.display = 'none';
            }
        });

        if (!barberId) {
            const defaultOption = serviceSelect.querySelector('option[value=""]');
            if (defaultOption) {
                defaultOption.textContent = '— Сначала выберите мастера —';
                defaultOption.style.display = 'block';
            }
            serviceSelect.value = '';
            startTimeInput.value = '';
            submitBtn.disabled = true;
            timeSlotsDiv.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4">👨‍🦰</div>
                    <p class="text-zinc-500">Сначала выберите мастера</p>
                </div>
            `;
            updateSelectedInfo();
            updateSteps();
            return;
        }

        // Загружаем услуги мастера
        fetch('{{ route("barber.services") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ barber_id: barberId })
        })
        .then(response => response.json())
        .then(data => {
            // Показываем только услуги выбранного мастера
            data.services.forEach(serviceId => {
                const option = serviceSelect.querySelector(`option[value="${serviceId}"]`);
                if (option) {
                    option.style.display = 'block';
                }
            });

            // Обновляем текст дефолтного选项а
            const defaultOption = serviceSelect.querySelector('option[value=""]');
            if (defaultOption) {
                defaultOption.textContent = '— Выберите услугу —';
                defaultOption.style.display = 'block';
            }

            serviceSelect.value = '';
            startTimeInput.value = '';
            submitBtn.disabled = true;
            
            timeSlotsDiv.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4">💈</div>
                    <p class="text-zinc-500">Теперь выберите услугу</p>
                </div>
            `;
            
            updateSelectedInfo();
            updateSteps();
        })
        .catch(error => {
            console.error(error);
        });
    }

    /**
     * Загрузка свободных слотов
     */
    function loadAvailableSlots() {
        const serviceId = serviceSelect.value;
        const barberId = barberSelect.value;
        const date = dateInput.value;

        startTimeInput.value = '';
        submitBtn.disabled = true;

        if (!serviceId || !barberId || !date) {
            timeSlotsDiv.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4">📅</div>
                    <p class="text-zinc-500">Выберите мастера, услугу и дату</p>
                </div>
            `;
            updateSelectedInfo();
            updateSteps();
            return;
        }

        timeSlotsDiv.innerHTML = `
            <div class="col-span-full text-center py-12">
                <div class="inline-block w-8 h-8 border-2 border-red-600 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-zinc-500 mt-4">Загрузка свободных слотов...</p>
            </div>
        `;

        fetch('{{ route("booking.available-slots") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                barber_id: barberId,
                service_id: serviceId,
                date: date
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Ответ:', data);
            timeSlotsDiv.innerHTML = '';

            if (data.slots && data.slots.length > 0) {
                data.slots.forEach(slot => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = slot;
                    button.className = 'time-slot w-full py-3 rounded-xl text-sm font-medium transition-all bg-zinc-800/50 border border-zinc-700 hover:border-red-600 hover:bg-red-600/10';

                    button.addEventListener('click', function () {
                        document.querySelectorAll('.time-slot').forEach(btn => {
                            btn.classList.remove('bg-red-600', 'border-red-600', 'text-white');
                            btn.classList.add('bg-zinc-800/50', 'border-zinc-700');
                        });

                        this.classList.remove('bg-zinc-800/50', 'border-zinc-700');
                        this.classList.add('bg-red-600', 'border-red-600', 'text-white');

                        startTimeInput.value = slot;
                        submitBtn.disabled = false;
                        updateSteps();
                    });

                    timeSlotsDiv.appendChild(button);
                });
            } else {
                timeSlotsDiv.innerHTML = `
                    <div class="col-span-full text-center py-12">
                        <div class="text-6xl mb-4">⏰</div>
                        <p class="text-amber-400">${data.message || 'Свободных слотов нет'}</p>
                        <p class="text-sm text-zinc-500 mt-2">Попробуйте выбрать другую дату</p>
                    </div>
                `;
            }

            updateSelectedInfo();
            updateSteps();
        })
        .catch(error => {
            console.error(error);
            timeSlotsDiv.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4">❌</div>
                    <p class="text-red-500">Ошибка загрузки слотов</p>
                </div>
            `;
        });
    }

    // События
    barberSelect.addEventListener('change', function () {
        filterServicesByBarber();
        updateSteps();
    });

    serviceSelect.addEventListener('change', function () {
        loadAvailableSlots();
        updateSelectedInfo();
        updateSteps();
    });

    dateInput.addEventListener('change', function () {
        loadAvailableSlots();
        updateSteps();
    });

    // Минимальная дата
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;

    // Инициализация
    filterServicesByBarber();
    updateSteps();
});
</script>

<style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    .time-slot {
        transition: all 0.2s ease;
    }
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }
    select option {
        background-color: #18181b;
    }
</style>
@endsection