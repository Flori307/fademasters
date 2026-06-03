<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Стандартная команда artisan (уже есть)
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// АВТОМАТИЧЕСКОЕ ОБНОВЛЕНИЕ СТАТУСОВ ЗАПИСЕЙ
Schedule::command('appointments:update-status')->daily();