@extends('layouts.app')

@section('title', $post->title ?? 'Post')

@section('content')

<style>
    .post-page {
        min-height: 100vh;
        background: #f0fdf4;
        padding-top: 90px;
        padding-bottom: 60px;
    }

    .post-wrapper {
        max-width: 680px;
        margin: 0 auto;
        padding: 0 16px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #16a34a;
        text-decoration: none;
        margin-bottom: 20px;
    }

    .back-link:hover { color: #15803d; text-decoration: none; }

    .post-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #dcfce7;
        overflow: hidden;
    }

    .post-image {
        width: 100%;
        height: auto;
        display: block;
        max-height: 480px;
        object-fit: contain;
        background: #f0fdf4;
    }

    .post-body {
        padding: 24px;
    }

    .author-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .author-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 2px solid #bbf7d0;
        flex-shrink: 0;
    }

    .author-name {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .author-time {
        font-size: 12px;
        color: #9ca3af;
        margin: 3px 0 0;
    }

    .post-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .post-caption {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.7;
    }

    .action-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 16px 0;
        border-top: 1px solid #f0fdf4;
        border-bottom: 1px solid #f0fdf4;
        margin: 20px 0 24px;
        flex-wrap: wrap;
    }

    .pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        border: 1.5px solid #e5e7eb;
        background: #fff;
        color: #6b7280;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        line-height: 1;
    }

    .pill-btn:hover { background: #f9fafb; border-color: #d1d5db; }

    .pill-btn.liked {
        border-color: #fecaca;
        background: #fff5f5;
        color: #ef4444;
    }

    .pill-btn.neutral { cursor: default; }
    .pill-btn.neutral:hover { background: #fff; border-color: #e5e7eb; }

    .delete-post-btn {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 12px;
        color: #fca5a5;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0;
        font-weight: 500;
    }

    .delete-post-btn:hover { color: #ef4444; }

    .comments-heading {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #9ca3af;
        margin-bottom: 20px;
    }

    .comment-row {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .comment-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 2px solid #bbf7d0;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .bubble-wrap { flex: 1; min-width: 0; }

    .bubble {
        display: inline-block;
        max-width: 100%;
        background: #f0fdf4;
        border-radius: 4px 18px 18px 18px;
        padding: 10px 14px;
    }

    .bubble-name {
        font-size: 12px;
        font-weight: 700;
        color: #15803d;
        margin: 0 0 4px;
    }

    .bubble-text {
        font-size: 14px;
        color: #1f2937;
        line-height: 1.55;
        margin: 0;
        word-break: break-word;
    }

    .comment-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 5px;
        padding-left: 4px;
        flex-wrap: wrap;
    }

    .meta-time { font-size: 11px; color: #9ca3af; }

    .comment-like-btn {
        font-size: 11px;
        font-weight: 700;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        color: #9ca3af;
        line-height: 1;
    }

    .comment-like-btn:hover { color: #ef4444; }
    .comment-like-btn.liked { color: #ef4444; }

    .comment-delete-btn {
        font-size: 11px;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        color: #d1d5db;
        font-weight: 500;
    }

    .comment-delete-btn:hover { color: #ef4444; }

    .empty-comments {
        text-align: center;
        padding: 28px 0;
        font-size: 14px;
        color: #9ca3af;
    }

    .comment-form-wrap {
        border-top: 1px solid #f0fdf4;
        margin-top: 8px;
        padding-top: 20px;
    }

    .comment-input-row {
        display: flex;
        gap: 12px;
        align-items: flex-end;
        background: #f9fafb;
        border: 1.5px solid #dcfce7;
        border-radius: 16px;
        padding: 12px 14px;
        transition: border-color 0.15s;
    }

    .comment-input-row:focus-within {
        border-color: #86efac;
        background: #fff;
    }

    .comment-input-row textarea {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        font-size: 14px;
        color: #1f2937;
        resize: none;
        line-height: 1.5;
        max-height: 120px;
        overflow-y: auto;
        font-family: inherit;
        padding: 0;
    }

    .comment-input-row textarea::placeholder { color: #9ca3af; }

    .comment-send-btn {
        flex-shrink: 0;
        background: #16a34a;
        color: #fff;
        border: none;
        border-radius: 999px;
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s;
        line-height: 1;
    }

    .comment-send-btn:hover { background: #15803d; }
</style>

<div class="post-page">
    <div class="post-wrapper">

        <a href="{{ url()->previous() }}" class="back-link">← Back</a>

        <div class="post-card">

            {{-- Contained image, full width of card, no clipping --}}
            <img src="{{ $post->image_url }}"
                class="post-image"
                alt="{{ $post->title ?? 'Post image' }}">

            <div class="post-body">

                {{-- Author --}}
                <div class="author-row">
                    <img class="author-avatar"
                        src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=dcfce7&color=15803d"
                        alt="{{ $post->user->name }}">
                    <div>
                        <p class="author-name">{{ $post->user->name }}</p>
                        <p class="author-time">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Title + Caption --}}
                @if ($post->title)
                    <h1 class="post-title">{{ $post->title }}</h1>
                @endif
                @if ($post->caption)
                    <p class="post-caption">{{ $post->caption }}</p>
                @endif

                {{-- Action bar --}}
                <div class="action-bar">
                    @auth
                        @if ($post->isLikedBy(auth()->user()))
                            <form action="{{ route('posts.unlike', $post) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="pill-btn liked">
                                    ❤️ {{ $post->likesCount() }} {{ Str::plural('Like', $post->likesCount()) }}
                                </button>
                            </form>
                        @else
                            <form action="{{ route('posts.like', $post) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="pill-btn">
                                    🤍 {{ $post->likesCount() }} {{ Str::plural('Like', $post->likesCount()) }}
                                </button>
                            </form>
                        @endif
                    @else
                        <span class="pill-btn neutral">
                            ❤️ {{ $post->likesCount() }} {{ Str::plural('Like', $post->likesCount()) }}
                        </span>
                    @endauth

                    <span class="pill-btn neutral">
                        💬 {{ $post->commentsCount() }} {{ Str::plural('Comment', $post->commentsCount()) }}
                    </span>

                    @if (auth()->id() === $post->user_id || (auth()->user()->role ?? null) === 'admin')
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                            style="display:inline; margin-left:auto"
                            onsubmit="return confirm('Delete this post?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="delete-post-btn">🗑 Delete post</button>
                        </form>
                    @endif
                </div>

                {{-- Comments list --}}
                @if ($post->comments->isNotEmpty())
                    <p class="comments-heading">
                        {{ $post->commentsCount() }} {{ Str::plural('Comment', $post->commentsCount()) }}
                    </p>
                @endif

                @forelse ($post->comments as $comment)
                    <div class="comment-row">
                        <img class="comment-avatar"
                            src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=dcfce7&color=15803d"
                            alt="{{ $comment->user->name }}">

                        <div class="bubble-wrap">
                            <div class="bubble">
                                <p class="bubble-name">{{ $comment->user->name }}</p>
                                <p class="bubble-text">{{ $comment->body }}</p>
                            </div>

                            <div class="comment-meta">
                                <span class="meta-time">{{ $comment->created_at->diffForHumans() }}</span>

                                @auth
                                    @if ($comment->isLikedBy(auth()->user()))
                                        <form action="{{ route('comments.unlike', $comment) }}" method="POST" style="display:inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="comment-like-btn liked">
                                                ❤️ {{ $comment->likes->count() }}
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('comments.like', $comment) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="submit" class="comment-like-btn">
                                                Like{{ $comment->likes->count() > 0 ? ' · ' . $comment->likes->count() : '' }}
                                            </button>
                                        </form>
                                    @endif

                                    @if (auth()->id() === $comment->user_id || auth()->id() === $post->user_id || (auth()->user()->role ?? null) === 'admin')
                                        <form action="{{ route('posts.comments.destroy', $comment) }}" method="POST"
                                            style="display:inline"
                                            onsubmit="return confirm('Delete this comment?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="comment-delete-btn">Delete</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="empty-comments">No comments yet — be the first!</p>
                @endforelse

                {{-- Comment input --}}
@auth
    <div class="comment-form-wrap">
        <form action="{{ route('posts.comments.store', $post) }}" method="POST">
            @csrf
            <div class="comment-input-row">
                <img class="comment-avatar" style="margin:0;flex-shrink:0"
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=dcfce7&color=15803d"
                    alt="{{ auth()->user()->name }}">
                <textarea name="body" required rows="1"
                    placeholder="Write a comment…"
                    oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'"></textarea>
                <button type="submit" class="comment-send-btn">Send</button>
            </div>
        </form>
    </div>
@else
    <div style="border-top: 1px solid #f0fdf4; margin-top: 8px; padding-top: 20px; text-align: center;">
        <p style="font-size: 14px; color: #9ca3af; margin-bottom: 12px;">
            Sign in to like or leave a comment.
        </p>
        <a href="{{ route('login') }}"
            style="display: inline-block; background: #16a34a; color: #fff; font-size: 13px; font-weight: 700;
                   padding: 9px 24px; border-radius: 999px; text-decoration: none;">
            Sign in
        </a>
    </div>
@endauth
            </div>
        </div>
    </div>
</div>

@endsection