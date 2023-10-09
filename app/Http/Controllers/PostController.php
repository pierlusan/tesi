<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Group $group)
    {
        $posts = Post::latest()->get();
        return view('posts.index', ['posts' => $posts, 'group' => $group]);
    }

}
