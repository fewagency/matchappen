<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreOpportunityRequest;
use Matchappen\Occupation;
use Matchappen\Opportunity;

class OpportunityController extends Controller
{

    public function __construct(Request $request)
    {
        $fields_to_trim = array_keys(StoreOpportunityRequest::rulesForUpdate());
        $middleware_options = ['only' => ['update', 'store']];
        $this->middleware('reformulator.explode:occupations', $middleware_options);
        $this->middleware('reformulator.trim:' . implode(',', $fields_to_trim), $middleware_options);
        $this->middleware('reformulator.strip_repeats:occupations', $middleware_options);

        $this->middleware('reformulator.concatenate:start_local, ,start_local_date,start_local_time',
            $middleware_options);
        $this->middleware('reformulator.datetime-local:start_local,start_local,' . Opportunity::getTimezoneAttribute(),
            $middleware_options);
        $this->middleware('reformulator.datetime-local:registration_end_local,registration_end_local,' . Opportunity::getTimezoneAttribute(),
            $middleware_options);
    }

    public function index()
    {
        $opportunities = Opportunity::viewable()->get();
        $number_of_bookable_opportunities = Opportunity::bookable()->count();

        return view('opportunity.index')->with(compact('opportunities', 'number_of_bookable_opportunities'));
    }

    public function show(Opportunity $opportunity)
    {
        if (!$opportunity->isViewable()) {
            return redirect()->action('OpportunityController@index');
        }

        return view('opportunity.show')->with(compact('opportunity'));
    }

    public function create(Request $request)
    {
        $workplace = $request->user()->workplace;

        $opportunity = new Opportunity();
        $opportunity->workplace()->associate($workplace);
        $opportunity->occupations = $workplace->occupations;

        return view('opportunity.create')->with(compact('opportunity', 'workplace'));
    }

    public function store(StoreOpportunityRequest $request)
    {
        $opportunity = new Opportunity($request->input());
        $opportunity->workplace()->associate($request->user()->workplace);
        $opportunity->save();

        $occupations = Occupation::getOrCreateFromNames($request->input('occupations'), $request->user());
        $opportunity->occupations()->sync($occupations);

        //TODO: trigger emails on opportunity created

        return redirect()->action('OpportunityController@edit', $opportunity->getKey());
    }

    public function edit(Opportunity $opportunity)
    {
        $this->authorize('update', $opportunity);

        return view('opportunity.edit')->with(compact('opportunity'));
    }

    public function update(Opportunity $opportunity, StoreOpportunityRequest $request)
    {
        $opportunity->update($request->input());

        $occupations = Occupation::getOrCreateFromNames($request->input('occupations'), $request->user());
        $opportunity->occupations()->sync($occupations);

        //TODO: trigger emails on opportunity update

        return redirect()->action('OpportunityController@edit', $opportunity->getKey());
    }

    public function booking(Opportunity $opportunity)
    {
        if (!$opportunity->isBookable()) {
            return redirect()->action('OpportunityController@show', $opportunity);
        }

        return view('opportunity.booking')->with(compact('opportunity'));
    }
}
