<?php

namespace App\Http\Controllers;

use App\Enum\EventStatus;
use App\Models\SingleEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SingleEventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $singleEvents = SingleEvent::whereNotNull('date')
                ->orderByRaw("FIELD(status, 'active', 'planned', 'completed', 'canceled')")
                ->orderBy('date', 'asc')
                ->get();
        } else{
            $singleEvents = $user->singleEvents()
                ->orderByRaw("FIELD(status, 'active', 'planned', 'completed', 'canceled')")
                ->orderBy('date', 'asc')
                ->get();
        }
        return view('single_events.index', ['singleEvents' => $singleEvents]);
    }

    public function show(SingleEvent $singleEvent)
    {
        if (!$singleEvent) {
            abort(404, 'Evento non trovato.');
        }
        return view('single_events.show', ['singleEvent' => $singleEvent]);
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

    public function lobby(){
        return view('single_events.lobby');
    }

    public function end(SingleEvent $singleEvent)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Non sei autorizzato a terminare questo evento.');
        }
        $singleEvent->status = EventStatus::COMPLETED;
        $singleEvent->save();
        return redirect()->back()->with('success', 'Evento terminato con successo.');
    }

    public function cancel(SingleEvent $singleEvent)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Non sei autorizzato a canecllare questo evento.');
        }
        $singleEvent->status = EventStatus::CANCELED;
        $singleEvent->save();
        return redirect()->back()->with('success', 'Evento cancellato con successo.');
    }

    public function destroy(SingleEvent $singleEvent)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Non sei autorizzato ad eliminare questo evento.');
        }
        $singleEvent->delete();
        return redirect()->route('single_events.index')
            ->with('success', 'Evento eliminato con successo.');
    }

}
