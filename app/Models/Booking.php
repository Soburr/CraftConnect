<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'artisan_id',
        'skill_id',
        'booking_date',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-700 border border-yellow-300',
            'in_progress' => 'bg-blue-100 text-blue-700 border border-blue-300',
            'completed' => 'bg-green-100 text-green-700 border border-green-300',
            'cancelled' => 'bg-red-100 text-red-700 border border-red-300',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
