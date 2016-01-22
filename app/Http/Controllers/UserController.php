<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Services\EmailTokenGuard;
use Matchappen\Workplace;

class UserController extends Controller
{
    public function dashboard(Request $request, EmailTokenGuard $token_guard)
    {
        if ($token_guard->check()) {
            if ($token_guard->checkSupervisor()) {
                return view('user.dashboard_supervisor');
            } else {
                return view('user.dashboard_student');
            }
        }

        $user = $request->user();
        if (!$user) {
            return redirect()->action('Auth\AuthController@getLogin');
        }

        if ($user->is_admin) {
            return view('user.dashboard_admin')->with([
                'user' => $user,
                'new_workplaces' => Workplace::publishRequested()->get(),
                'unpublished_workplaces' => Workplace::unpublished()->get(),
            ]);
        } else {
            return view('user.dashboard_workplace')->with(['user' => $user, 'workplace' => $user->workplace]);
        }
    }
}