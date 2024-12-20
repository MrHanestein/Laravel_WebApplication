<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewLikeNotification;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $request->validate([
            'type' => 'required|in:post,comment',
            'id' => 'required|integer'
        ]);

        $user = Auth::user();
        $model = $request->type === 'post' ? Post::class : Comment::class;
        $item = $model::find($request->id);

        if (!$item) {
            return response()->json(['error'=>'Not found'],404);
        }

        // Check if already liked
        if ($item->likes()->where('user_id',$user->id)->exists()) {
            return response()->json(['message'=>'Already liked'],200);
        }

        $item->likes()->create(['user_id'=>$user->id]);

        // Notify owner if not same user
        if ($item->user_id != $user->id) {
            $description = $item instanceof Post ? "your post '{$item->title}'" : "your comment";
            $item->user->notify(new NewLikeNotification($user->name, $description));
        }

        return response()->json(['message'=>'Liked successfully']);
    }

    public function unlike(Request $request)
    {
        $request->validate([
            'type' => 'required|in:post,comment',
            'id' => 'required|integer'
        ]);

        $user = Auth::user();
        $model = $request->type === 'post' ? Post::class : Comment::class;
        $item = $model::find($request->id);

        if (!$item) {
            return response()->json(['error'=>'Not found'],404);
        }

        $like = $item->likes()->where('user_id',$user->id)->first();
        if (!$like) {
            return response()->json(['message'=>'Not liked yet'],200);
        }

        $like->delete();
        return response()->json(['message'=>'Unliked successfully']);
    }
}
