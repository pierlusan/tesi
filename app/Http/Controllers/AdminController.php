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
}
