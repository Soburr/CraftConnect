<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['skill_id','booking_id', 'client_id', 'artisan_id', 'rating', 'review'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
