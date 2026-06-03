<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateAppointmentStatus extends Command
{
    protected $signature = 'appointments:update-status';
    protected $description = 'Update appointment statuses to completed after the date has passed';

    public function handle()
    {
        // Находим все записи со статусом 'pending' у которых дата уже прошла
        $updated = Appointment::where('status', 'pending')
            ->where('appointment_date', '<', Carbon::today())
            ->update(['status' => 'completed']);

        $this->info("✅ Обновлено {$updated} записей до статуса 'Завершена'.");
        
        return Command::SUCCESS;
    }
}