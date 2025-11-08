<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artisan extends Model
{
    protected $fillable = [
        'user_id',
        'hall_of_residence',
        'skill_id',
        'category_id',
        'years_of_experience',
        'portfolio_url',
        'bio',
        'faculty',
        'department',
        'room_number',
        'matric_no',
        'avatar',
        'score',
        'tier'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function calculateTier($score, $averageRating)
    {
        if ($score >= 200 && $averageRating >= 4.8) return 'Elite';
        if ($score >= 150 && $averageRating >= 4.5) return 'Gold';
        if ($score >= 50 && $averageRating >= 4.0) return 'Silver';
        return 'Bronze';
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'artisan_id');
    }
}
