<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artisan extends Model
{
    protected $fillable = [
        'user_id',
        'hall_of_residence',
        'skill',
        'years_of_experience',
        'portfolio_url'
     ];
     public function user(): BelongsTo
     {
         return $this->belongsTo(User::class);
     }
}
