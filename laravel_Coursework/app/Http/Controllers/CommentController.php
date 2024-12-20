<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Update the specified comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  Comment ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

        // Retrieve the comment or fail
        $comment = Comment::findOrFail($id);

        // Authorization: Ensure the authenticated user owns the comment
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Update the comment
        $comment->comment_text = $request->comment_text;
        $comment->save();

        // Handle AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment_text' => $comment->comment_text,
                'message' => 'Comment updated successfully.',
            ]);
        }

        // Redirect back with success message for non-AJAX requests
        return redirect()->back()->with('success', 'Comment updated successfully.');
    }
    public function edit($id)
    {
        // Retrieve the comment or fail
        $comment = Comment::findOrFail($id);

        // Authorization: Ensure the authenticated user owns the comment
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Return the edit view with the comment data
        return view('home.edit_comment', compact('comment'));
    }

}

