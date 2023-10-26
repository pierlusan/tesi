<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function dashboard()
    {
        $events = [];

        $appointments = Event::whereNotNull('date')->get();
        $groups = Group::whereNotNull('id')->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->title,
                'start' => $appointment->date,
                'end' => now()->parse($appointment->date)->addHour(2),
                'url' => route('events.show', ['group' => $appointment->group, 'event' => $appointment]),
                'extendedProps' => [
                    'description' => $appointment->description,
                    'status' => $appointment->status,
                    'group' => $appointment->group->name,
                ],
            ];
        }
        return view('dashboard', ['events' => $events, 'groups' => $groups]);
    }
}
