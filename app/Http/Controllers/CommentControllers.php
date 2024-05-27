<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Posts;

class CommentControllers extends Controller
{
    public function store(Request $request, Posts $post)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->route('post.show', $post->id)->with('success', 'Komentar berhasil ditambahkan.');
    }

    // Update an existing comment
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('post.show', $comment->post_id);
    }

    // Delete an existing comment
    public function destroy(Comment $comment)
    {
        $postId = $comment->post_id;
        $comment->delete();

        return redirect()->route('post.show', $postId);
    }
}