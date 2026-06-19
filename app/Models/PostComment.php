<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostComment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'body',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class, 'post_comment_id');
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        if ($this->relationLoaded('likes')) {
            return $this->likes->contains('user_id', $user->id);
        }
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
