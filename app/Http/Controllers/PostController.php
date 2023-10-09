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
            abort(404);
        }
        return view('posts.show', ['post' => $post, 'group' => $group]);
    }

}
