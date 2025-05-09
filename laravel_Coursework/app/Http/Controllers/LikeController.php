<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewLikeNotification;

class LikeController extends Controller
{
    /**
     * Handle the like action for posts and comments.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'type' => 'required|in:post,comment',
            'id' => 'required|integer',
        ]);

        // Retrieve authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Determine the model based on type
        $model = $request->type === 'post' ? Post::class : Comment::class;
        $item = $model::find($request->id);

        if (!$item) {
            return response()->json(['error' => 'Not found'], 404);
        }

        // Check if already liked
        if ($item->likes()->where('user_id', $user->id)->exists()) {
            return view('home.like_comment');
            return response()->json(['message' => 'Already liked'], 200);
        }

        // Create a new like
        $item->likes()->create(['user_id' => $user->id]);

        // Notify the owner if the liker is not the owner
        if ($item->user_id !== $user->id) {
            $description = $item instanceof Post ? "your post '{$item->title}'" : "your comment";
            $item->user->notify(new NewLikeNotification($user->name, $description));
        }

        return response()->json(['message' => 'Liked successfully'], 201);
    }

    /**
     * Handle the unlike action for posts and comments.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'type' => 'required|in:post,comment',
            'id' => 'required|integer',
        ]);

        // Retrieve authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Determine the model based on type
        $model = $request->type === 'post' ? Post::class : Comment::class;
        $item = $model::find($request->id);

        if (!$item) {
            return response()->json(['error' => 'Not found'], 404);
        }

        // Find the like
        $like = $item->likes()->where('user_id', $user->id)->first();

        if (!$like) {
            return response()->json(['message' => 'Not liked yet'], 200);
        }

        // Delete the like
        $like->delete();

        return response()->json(['message' => 'Unliked successfully'], 200);
    }
}
