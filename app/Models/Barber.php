<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nickname',
        'photo',
        'specialization',
        'experience_years',
        'description',
        'working_days',
        'start_time',
        'end_time',
        'slot_duration_minutes',
        'max_appointments_per_day',
        'is_active',
    ];

    protected $casts = [
        'working_days' => 'array',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    // Отношения
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function reviews()
{
    return $this->hasMany(Review::class)->where('is_approved', true);
}

public function allReviews()
{
    return $this->hasMany(Review::class);
}

public function getRatingAttribute()
{
    $reviews = $this->reviews;
    if ($reviews->isEmpty()) {
        return 0;
    }
    return round($reviews->avg('rating'), 1);
}

public function getReviewsCountAttribute()
{
    return $this->reviews->count();
}

public function approvedReviews()
{
    return $this->hasMany(Review::class)->where('is_approved', true);
}


}