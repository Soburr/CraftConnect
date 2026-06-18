<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->paginate(12);
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title'   => ['nullable', 'string', 'max:255'],
            'image'   => ['required', 'image', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:2000'],
        ]);

        $path = $request->file('image')->store('posts', 'public');

        $post = Auth::user()->posts()->create([
            'title'      => $validated['title'] ?? null,
            'image_path' => $path,
            'caption'    => $validated['caption'] ?? null,
        ]);

        if ($request->wantsJson()) {
            $post->loadMissing('user');
            return response()->json([
                'success' => true,
                'message' => 'Post shared successfully.',
                'post'    => [
                    'id'               => $post->id,
                    'title'            => $post->title,
                    'caption'          => $post->caption,
                    'image_url'        => $post->image_url,
                    'created_at_human' => $post->created_at->diffForHumans(),
                    'likes_count'      => 0,
                    'comments_count'   => 0,
                    'user'             => [
                        'id'         => $post->user->id,
                        'name'       => $post->user->name,
                    ],
                ],
            ], 201);
        }

        return back()->with('success', 'Post shared successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $user = Auth::user();
        abort_unless(
            $user->id === $post->user_id || ($user->role ?? null) === 'admin',
            403
        );
        Storage::disk('public')->delete($post->image_path);
        $post->delete();
        return back()->with('success', 'Post deleted.');
    }

    public function like(Post $post): RedirectResponse
    {
        $post->likes()->firstOrCreate(['user_id' => Auth::id()]);
        return back();
    }

    public function unlike(Post $post): RedirectResponse
    {
        $post->likes()->where('user_id', Auth::id())->delete();
        return back();
    }

    public function comment(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate(['body' => ['required', 'string', 'max:1000']]);
        $post->comments()->create(['user_id' => Auth::id(), 'body' => $validated['body']]);
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
            403
        );
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}