<?php

namespace App\Http\Controllers;

use App\Models\SingleEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SingleEventController extends Controller
{
    public function index()
    {
        $singleEvents = SingleEvent::whereNotNull('date')->get();
        return view('single_events.index', ['singleEvents' => $singleEvents]);
    }

    public function create()
    {
        $users = User::where('approved', true)
            ->where('is_admin', false)
            ->orderBy('name', 'asc')
            ->get();
        return view('single_events.create', ['users'=> $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'type' => 'nullable|string',
        ]);

        $event = new SingleEvent();
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->date = Carbon::parse($request->input('date'))->format('Y-m-d H:i');
        $event->type = $request->input('type');
        $event->client_id = $request["client"];
        $event->save();

        return redirect()->route('single_events.index')
            ->with('success', 'Evento creato con successo');
    }

}
