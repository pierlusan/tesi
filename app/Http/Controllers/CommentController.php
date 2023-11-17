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
            'attachment' => 'file|mimes:pdf,docx,doc,xls,xlsx,ppt,pptx,jpg,png,gif,mp3,mp4,avi,zip,rar,7z,txt,rtf,md',
        ]);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $post->id;
        $comment->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $fileName = $attachment->getClientOriginalName();
                $filePath = $attachment->store('attachments', 'public');
                $comment->attachments()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('posts.show', ['group' => $group, 'post' => $post])
            ->with('success', 'Commento inviato con successo!');
    }

    public function destroy(Group $group, Post $post, Comment $comment)
    {
        if (auth()->user()->isAdmin() || auth()->id() === $comment->user_id) {
            $comment->delete();
            return redirect()->back()->with('success', 'Commento eliminato con successo');
        } else {
            return redirect()->back()->with('error', 'Non sei autorizzato a eliminare questo commento');
        }
    }


}
