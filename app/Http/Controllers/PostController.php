<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])
            ->latest()
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:5120'], // 5MB max
            'caption' => ['nullable', 'string', 'max:2000'],
        ]);

        $path = $request->file('image')->store('posts', 'public');

        Auth::user()->posts()->create([
            'title' => $validated['title'] ?? null,
            'image_path' => $path,
            'caption' => $validated['caption'] ?? null,
        ]);

        return back()->with('success', 'Post shared successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $user = Auth::user();

        abort_unless(
            $user->id === $post->user_id || ($user->role ?? null) === 'admin',
            403,
            'You are not authorized to delete this post.'
        );

        Storage::disk('public')->delete($post->image_path);
        $post->delete();

        return back()->with('success', 'Post deleted.');
    }

    /**
     * Like a post. Idempotent: liking an already-liked post is a no-op.
     */
    public function like(Post $post): RedirectResponse
    {
        $post->likes()->firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        return back();
    }

    public function unlike(Post $post): RedirectResponse
    {
        $post->likes()->where('user_id', Auth::id())->delete();

        return back();
    }

    public function comment(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Comment added.');
    }

    public function destroyComment(PostComment $comment): RedirectResponse
    {
        $user = Auth::user();
        $post = $comment->post;

        abort_unless(
            $user->id === $comment->user_id
                || $user->id === $post->user_id
                || ($user->role ?? null) === 'admin',
            403,
            'You are not authorized to delete this comment.'
        );

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
