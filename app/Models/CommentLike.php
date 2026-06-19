<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $fillable = ['post_comment_id', 'user_id'];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'post_comment_id');
    }

    public function user(): BelongsTo
    { 
        return $this->belongsTo(User::class);
    }
}
