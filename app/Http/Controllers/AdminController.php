<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showPendingUsers()
    {
        return view('pending_users',[
            'users' => User::__all(),
        ]);
    }

    public function approveUser(User $user)
    {
        if (!auth()->user()->is_admin)
        {
            abort(403, 'Accesso non autorizzato');
        }
        $user->update(['approved' => true]);
        return redirect()->route('admin.pending_users')
            ->with('success', 'Utente approvato con successo');
    }
}
