<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
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

    public function create()
    {
        $users = User::all();
        return view('groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);
        $group = Group::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        $group->users()->attach(auth()->user());
        $selectedUserIds = $request->input('selected_users', []);
        $group->users()->attach($selectedUserIds);

        return redirect()->route('groups.index')->with('success', 'Gruppo creato con successo!');
    }
}
