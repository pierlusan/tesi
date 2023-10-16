<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Group $group, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->user()->id; // Imposta l'utente corrente come autore del commento
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->route('posts.show', ['group' => $group, 'post' => $post])
            ->with('success', 'Commento aggiunto con successo!');
    }

}
