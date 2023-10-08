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
        $users = User::where('approved', true)
            ->where('is_admin', false)
            ->orderBy('name', 'asc')
            ->get();
        return view('groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'users' => 'required|array',
        ]);

        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        $group->users()->attach(auth()->user());
        $group->users()->attach($request->input('users'));

        return redirect()->route('groups.index')->with('success', 'Gruppo creato con successo.');
    }

    public function edit(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);
        if ($request->has('name')) {
            $group->update([
                'name' => $request->input('name'),
            ]);
        }
        if ($request->has('description')) {
            $group->update([
                'description' => $request->input('description'),
            ]);
        }
        return response()->json(['message' => 'Nome del gruppo aggiornato con successo']);
    }


}
