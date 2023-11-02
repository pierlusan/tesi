<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\SingleEvent;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function dashboard()
    {
        $events = [];
        $user = Auth::user();
        $userGroups = $user->groups;

        $groupEvents = Event::whereIn('group_id', $userGroups->pluck('id')->toArray())
            ->whereNotNull('date')
            ->get();
        //$groups = Group::whereNotNull('id')->get();
        if ($user->isAdmin()) {
            $singleEvents = SingleEvent::whereNotNull('date')->get();
        } else{
            $singleEvents = $user->singleEvents()->get();
        }
        foreach ($groupEvents as $groupEvent) {
            $events[] = [
                'id' => $groupEvent->id,
                'title' => $groupEvent->title,
                'start' => $groupEvent->date,
                'end' => now()->parse($groupEvent->date)->addHour(2),
                'url' => route('events.show', ['group' => $groupEvent->group, 'event' => $groupEvent]),
                'extendedProps' => [
                    'description' => $groupEvent->description,
                    'status' => $groupEvent->status,
                    'group' => $groupEvent->group->name,
                ],
            ];
        }
        foreach ($singleEvents as $singleEvent) {
            $events[] = [
                'id' => $singleEvent->id,
                'title' => $singleEvent->title,
                'start' => $singleEvent->date,
                'end' => now()->parse($singleEvent->date)->addHour(2),
                'url' => route('single_events.show',  [ 'singleEvent' => $singleEvent]),
                'extendedProps' => [
                    'client'=> $singleEvent->client->name,
                    'description' => $singleEvent->description,
                    'status' => $singleEvent->status,
                ],
            ];
        }
        return view('dashboard', ['events' => $events, 'groups' => $userGroups]);
    }
}
