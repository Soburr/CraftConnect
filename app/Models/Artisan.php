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
        'avatar'
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

     public function location() {
        return $this->belongsTo(Location::class);
    }

}
