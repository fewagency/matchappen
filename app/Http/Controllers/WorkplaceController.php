<?php

namespace Matchappen\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreWorkplaceRequest;
use Matchappen\Occupation;
use Matchappen\User;
use Matchappen\Workplace;

class WorkplaceController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);

        $fields_to_trim = array_keys(StoreWorkplaceRequest::rulesForUpdate());
        $this->middleware('reformulator.explode:occupations', ['only' => 'update']);
        $this->middleware('reformulator.trim:' . implode(',', $fields_to_trim), ['only' => 'update']);
        $this->middleware('reformulator.strip_repeats:occupations', ['only' => 'update']);
    }

    public function index()
    {
        $workplaces = Workplace::published()->get();

        return view('workplace.index')->with(compact('workplaces'));
    }

    public function show(Request $request, Workplace $workplace)
    {
        // Don't display unpublished workplaces to non-administrators
        if (!$workplace->isPublished() and Gate::denies('update', $workplace)) {
            return redirect()->action('WorkplaceController@index');
        }

        return view('workplace.show')->with(compact('workplace'));
    }

    public function edit(Workplace $workplace)
    {
        $this->authorize('update', $workplace);

        return view('workplace.edit')->with(compact('workplace'));
    }

    public function update(Workplace $workplace, StoreWorkplaceRequest $request)
    {
        $workplace->update($request->input());

        $occupations = Occupation::getOrCreateFromNames($request->input('occupations'), $request->user());
        $workplace->occupations()->sync($occupations);

        // Email admin when workplace has been updated
        \Mail::queue('emails.workplace_update_admin_notification', compact('workplace'),
            function ($message) use ($workplace) {
                $message->to(User::getAdminEmails());
                $message->subject(trans('workplace.update_admin_notification_mail_subject',
                    ['workplace' => $workplace->name]));
            });

        return redirect()->action('WorkplaceController@edit', $workplace->getKey());
    }

    public function approve(Workplace $workplace)
    {
        $this->authorize('publish', $workplace);
        $workplace->publish();

        return redirect()->back()->with('status', trans('messages.workplace-approved'));

    }
}