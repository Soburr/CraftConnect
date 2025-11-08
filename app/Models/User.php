<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function artisan()
    {
        return $this->hasOne(Artisan::class);
    }

    public function artisanBookings()
    {
        return $this->hasMany(Booking::class, 'artisan_id');
    }

    public function clientBookings()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function clientProfile()
    {
      return $this->hasOne(Client::class);
    }

    public function artisansReview()
    {
      return $this->hasMany(Review::class, 'artisan_id');
    }

    public function clientReview()
    {
      return $this->hasMany(Review::class, 'client_id');
    }

    public function skill()
    {
      return $this->belongsTo(Skill::class, 'skill_id');
    }
}
