<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsMemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $groupId = $request->route('group');
        $user = $request->user();
        $userGroups = $user->groups;
        $isMember = $userGroups->contains('id', $groupId);
        //dd($isMember);

        if (!$isMember) {
            abort(403, 'Accesso non autorizzato.');
        }
        return $next($request);
    }

}
