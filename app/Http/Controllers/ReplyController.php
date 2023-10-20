<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Reply;

class ReplyController extends Controller
{

    public function store(Request $request, Group $group, Post $post, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply = new Reply();
        $reply->user_id = auth()->user()->id;
        $reply->content = $request->input('content');
        $reply->parent_id = $comment->id;
        $reply->save();

        return redirect()->route('posts.show', ['group' => $group, 'post' => $post])
            ->with('success', 'Risposta inviata con successo!');
    }

    public function destroy(Group $group, Post $post, Comment $comment, Reply $reply)
    {
        if (auth()->user()->isAdmin() || auth()->id() === $reply->user_id) {
            $reply->delete();
            return redirect()->back()
                ->with('success', 'Risposta eliminata con successo');
        } else {
            abort(403, 'Non sei autorizzato a eliminare questa risposta.');
        }
    }

}
