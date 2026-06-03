@extends('layouts.app')

@section('title', 'Мои записи — Fade Masters')

@section('content')
<div class="bg-zinc-950 py-16 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-4xl font-bold">Мои записи</h1>
            <a href="{{ route('booking.create') }}" 
               class="bg-red-600 hover:bg-red-700 px-8 py-4 rounded-2xl font-semibold">
                Новая запись
            </a>
        </div>

        @if($appointments->isEmpty())
            <div class="bg-zinc-900 rounded-3xl p-20 text-center">
                <p class="text-2xl text-zinc-400 mb-6">У вас пока нет записей</p>
                <a href="{{ route('booking.create') }}" class="bg-red-600 hover:bg-red-700 px-10 py-5 rounded-2xl inline-block">
                    Записаться на стрижку
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($appointments as $appointment)
                <div class="bg-zinc-900 rounded-3xl p-8 grid md:grid-cols-12 gap-6 items-center">
                    <div class="md:col-span-2 text-center md:text-left">
                        <div class="text-4xl font-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m') }}</div>
                        <div class="text-sm text-zinc-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l') }}</div>
                        <div class="text-3xl font-mono mt-2">{{ $appointment->start_time }}</div>
                    </div>

                    <div class="md:col-span-6">
                        <h3 class="text-xl font-semibold">{{ $appointment->service->name }}</h3>
                        <p class="text-zinc-400">Мастер: <span class="font-medium text-white">{{ $appointment->barber->nickname }}</span></p>
                        @if($appointment->notes)
                            <p class="text-sm text-zinc-500 mt-1">"{{ $appointment->notes }}"</p>
                        @endif
                    </div>

                    <div class="md:col-span-2">
                        <span class="px-6 py-2 rounded-full text-sm font-medium
                            @if($appointment->status == 'confirmed') bg-emerald-600 
                            @elseif($appointment->status == 'pending') bg-amber-600 
                            @elseif($appointment->status == 'cancelled') bg-red-700 
                            @else bg-zinc-700 @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>

                    <div class="md:col-span-2 text-right">
                        @if(in_array($appointment->status, ['pending', 'confirmed']))
                            <form method="POST" action="{{ route('appointments.cancel', $appointment) }}">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Вы действительно хотите отменить запись?')"
                                        class="text-red-500 hover:text-red-600 text-sm font-medium">
                                    Отменить
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection