<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Group $group)
    {
        return view('posts.index', ['group' => $group]);
    }


}
