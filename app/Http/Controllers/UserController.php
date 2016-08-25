<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;
use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Booking;
use Matchappen\Services\EmailTokenGuard;
use Matchappen\Workplace;

class UserController extends Controller
{
    public function dashboard(Request $request, EmailTokenGuard $token_guard)
    {
        if ($token_guard->check()) {
            if ($token_guard->checkSupervisor()) {
                $bookings = Booking::forSupervisor($token_guard->email())->upcoming()->with('opportunity')->get()->sortBy('opportunity.start');
                $passed_bookings = Booking::forSupervisor($token_guard->email())->recentlyPassed()->with('opportunity')->get()->sortByDesc('opportunity.start');

                return view('user.dashboard_supervisor')->with(compact('bookings', 'passed_bookings'));
            } else {
                $bookings = Booking::forStudent($token_guard->email())->upcoming()->with('opportunity')->get()->sortBy('opportunity.start');
                $passed_bookings = Booking::forStudent($token_guard->email())->recentlyPassed()->with('opportunity')->get()->sortByDesc('opportunity.start');

                return view('user.dashboard_student')->with(compact('bookings', 'passed_bookings'));
            }
        }

        $user = $request->user();
        if (!$user) {
            return redirect()->action('Auth\AuthController@getLogin');
        }

        if ($user->isAdmin()) {
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