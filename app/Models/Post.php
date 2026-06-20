<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'image_path', 'caption', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            $post->slug = Str::random(12);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class)->latest();
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        if ($this->relationLoaded('likes')) {
            return $this->likes->contains('user_id', $user->id);
        }
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function likesCount(): int
    {
        return $this->relationLoaded('likes') ? $this->likes->count() : $this->likes()->count();
    }

    public function commentsCount(): int
    {
        return $this->relationLoaded('comments') ? $this->comments->count() : $this->comments()->count();
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->image_path);
    }
}