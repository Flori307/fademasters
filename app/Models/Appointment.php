<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barber_id',
        'service_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'cancelled_at',
        'cancelled_reason',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'cancelled_at' => 'datetime',
    ];

    // Отношения
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Аксессор для статуса на русском
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending'    => 'В ожидании',
            'completed'  => 'Завершена',
            'cancelled'  => 'Отменена',
            default      => ucfirst($this->status),
        };
    }

    // Аксессор для цвета статуса
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending'    => 'amber',
            'completed'  => 'green',
            'cancelled'  => 'red',
            default      => 'zinc',
        };
    }

    // Автоматическое обновление статуса
    public static function boot()
    {
        parent::boot();

        static::saving(function ($appointment) {
            // Если запись не отменена и дата прошла, статус = completed
            if ($appointment->status !== 'cancelled' && $appointment->appointment_date->isPast()) {
                $appointment->status = 'completed';
            }
        });
    }
}