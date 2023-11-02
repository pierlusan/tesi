<?php

namespace App\Http\Controllers;

use App\Enum\EventStatus;
use App\Models\Event;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Group $group)
    {
        $events = $group->events()
            ->orderByRaw("FIELD(status, 'active', 'planned', 'completed', 'canceled')")
            ->orderBy('date', 'asc')
            ->get();
        return view('events.index', ['events' => $events, 'group' => $group]);
    }

    public function show(Group $group, Event $event)
    {
        if (!$event) {
            abort(404, 'Evento non trovato.');
        }
        return view('events.show', ['group' => $group, 'event' => $event]);
    }

    public function create(Group $group)
    {
        return view('events.create', ['group' => $group]);
    }

    public function store(Request $request, Group $group)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'type' => 'nullable|string',
        ]);

        $event = new Event;
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');
        $event->type = $request->input('type');
        $event->group_id = $group->id;
        $event->user_id = auth()->user()->id;
        $event->save();

        return redirect()->route('events.index', ['group' => $group])
            ->with('success', 'Evento creato con successo');
    }

    public function end(Group $group, Event $event)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Non sei autorizzato a terminare questo evento.');
        }
        $event->status = EventStatus::COMPLETED;
        $event->save();
        return redirect()->back()->with('success', 'Evento terminato con successo.');
    }

    public function cancel(Group $group, Event $event)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Non sei autorizzato a canecllare questo evento.');
        }
        $event->status = EventStatus::CANCELED;
        $event->save();
        return redirect()->back()->with('success', 'Evento cancellato con successo.');
    }

    public function destroy(Group $group, Event $event)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Non sei autorizzato ad eliminare questo evento.');
        }
        $event->delete();
        return redirect()->route('events.index', ['group' => $group])
            ->with('success', 'Evento eliminato con successo.');
    }


}
