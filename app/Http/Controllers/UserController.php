<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        if ($user->is_admin) {
            return view('user.dashboard_admin')->with(['user' => $user]);
        } else {
            return view('user.dashboard_workplace')->with(['user' => $user, 'workplace' => $user->workplace]);
        }
    }
}