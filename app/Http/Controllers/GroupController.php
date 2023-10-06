<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    public function index()
    {
        $user = Auth::user();
        $groups = $user->groups;
        return view('groups.index', compact('groups'));
    }
}
