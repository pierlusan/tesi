<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Group $group)
    {
        $posts = $group->posts()->latest()->get();
        return view('posts.index', ['posts' => $posts, 'group' => $group]);
    }

    public function show(Group $group, Post $post)
    {
        $postId = $post->id;
        $groupId = $group->id;
        $post = Post::where('group_id', $groupId)->where('id', $postId)->first();
        if (!$post) {
            abort(404, 'Post non trovato.');
        }
        return view('posts.show', ['post' => $post, 'group' => $group]);
    }

    public function create(Group $group)
    {
        return view('posts.create', ['group' => $group]);
    }

    public function store(Request $request, Group $group)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|string',
            'attachment' => 'file|mimes:pdf,docx,doc,xls,xlsx,ppt,pptx,jpg,png,gif,mp3,mp4,avi,zip,rar,7z,txt,rtf,md',
        ]);

        $post = new Post;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->group_id = $group->id;
        $post->user_id = auth()->user()->id;
        $post->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $postId = $post->id;
                $fileName = $attachment->getClientOriginalName();
                $filePath = $attachment->store('attachments', 'public');
                $post->attachments()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('posts.show', ['group' => $group->id, 'post' => $post->id])
            ->with('success', 'Post creato con successo.');
    }

    public function destroy(Group $group, Post $post)
    {
        $user = auth()->user();
        if (auth()->user()->isAdmin() || $user->isAuthor($post)) {
            $post->delete();
            return redirect()->route('posts.index', ['group' => $group])
                ->with('success', 'Il post è stato eliminato con successo.');
        } else {
            abort(403, 'Non sei autorizzato a eliminare questo post.');
        }
    }

}
