<?php

namespace App\Http\Controllers;

use App\Events\NoticeEvent;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $groups = $user->groups;

        return view('groups.index', compact('groups'));
    }

    public function show(Group $group)
    {
        $groupId = $group->id;
        $usersNotInGroup = User::whereDoesntHave('groups', function ($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->get();

        return view('groups.show', ['group' => $group, 'users' => $usersNotInGroup]);
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
            'description' => 'required|string',
            'users' => 'required|array',
        ]);

        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();
        $group->users()->attach(auth()->user());
        $group->users()->attach($request->input('users'));

        $messaggio = ['utente'=> $request->input('users'), 'messaggio'=>'Sei stato inserito nel gruppo: '.$request->input('name')];
        //dd($messaggio);

        NoticeEvent::dispatch($messaggio);

        return redirect()->route('groups.show', ['group' => $group->id])->with('success', 'Gruppo creato con successo.');
    }

    public function edit(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
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

    public function add(Request $request, Group $group)
    {
        $request->validate([
            'users' => 'required|array',
        ]);

        $group->users()->attach($request->input('users'));

        return redirect()->route('groups.show', ['group' => $group])->with('success', 'Utenti aggiunti con successo al gruppo.');
    }

    public function remove(Group $group, User $user)
    {
        $group->users()->detach($user->id);

        return redirect()->route('groups.show', $group)->with('success', 'Utente rimosso con successo dal gruppo');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Gruppo eliminato con successo.');
    }

}
