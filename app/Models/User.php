<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CanResetPasswordTrait;

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
        'status',
        'verification_token',
        'verification_token_expires',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
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
            'verification_token_expires' => 'datetime',
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
    public function hasCompletedProfile()
    {
        if ($this->role === 'client') {
            // Check if client record exists and has required fields filled
            return $this->client
                && !empty($this->client->hall_of_residence)
                && !empty($this->client->faculty)
                && !empty($this->client->department)
                && !empty($this->client->room_number)
                && !empty($this->client->matric_no);
        }

        if ($this->role === 'artisan') {
            // Check if artisan record exists and has required fields filled
            return $this->artisan
                && !empty($this->artisan->hall_of_residence)
                && !empty($this->artisan->skill_id)
                && !empty($this->artisan->category_id)
                && !empty($this->artisan->years_of_experience)
                && !empty($this->artisan->faculty)
                && !empty($this->artisan->department)
                && !empty($this->artisan->room_number)
                && !empty($this->artisan->matric_no);
        }

    return true;
    }
    /**
     * Generate and store verification token
     */
    public function generateVerificationToken()
    {
        $plainToken = Str::random(60);
        $this->verification_token = hash('sha256', $plainToken);
        $this->verification_token_expires = now()->addHours(24);
        $this->save();

        return $plainToken;
    }

    /**
     * Check if verification token is valid
     */
    public function hasValidVerificationToken($token)
    {
        if (!$this->verification_token) {
            return false;
        }

        if ($this->verification_token_expires && $this->verification_token_expires->isPast()) {
            return false;
        }

        return hash_equals($this->verification_token, hash('sha256', $token));
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        $this->verification_token = null;
        $this->verification_token_expires = null;
        $this->save();
    }

    /**
     * Check if email is verified
     */
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }
}
