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
        // Validazione dei dati del modulo
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'users' => 'required|array',
        ]);

        // Crea il gruppo
        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        // Aggiungi gli utenti selezionati al gruppo
        $group->users()->attach(auth()->user());
        $group->users()->attach($request->input('users'));

        // Altre operazioni o reindirizzamento a seconda delle tue esigenze
        return redirect()->route('groups.index')->with('success', 'Gruppo creato con successo.');
    }
}
