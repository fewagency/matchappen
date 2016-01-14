<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreOpportunityRequest;
use Matchappen\Opportunity;

class OpportunityController extends Controller
{

    public function __construct(Request $request)
    {
        $fields_to_trim = array_keys(StoreOpportunityRequest::rulesForUpdate());
        $this->middleware('input.trim:' . implode(',', $fields_to_trim), ['only' => ['update', 'store']]);
    }

    public function index()
    {
        $opportunities = Opportunity::viewable()->get();

        return view('opportunity.index')->with(compact('opportunities'));
    }

    public function show(Opportunity $opportunity)
    {
        if (!$opportunity->isViewable()) {
            return redirect(action('OpportunityController@index'));
        }

        return view('opportunity.show')->with(compact('opportunity'));
    }

    public function create(Request $request)
    {
        $workplace = $request->user()->workplace;

        $opportunity = value(new Opportunity())->workplace()->associate($workplace);

        return view('opportunity.create')->with(compact('opportunity', 'workplace'));
    }

    public function store(StoreOpportunityRequest $request)
    {
        $opportunity = new Opportunity($request->input());
        $opportunity->workplace()->associate($request->user()->workplace);
        $opportunity->save();

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

        //TODO: trigger emails on opportunity update

        return redirect()->action('OpportunityController@edit', $opportunity->getKey());
    }

    public function booking(Opportunity $opportunity)
    {
        if (!$opportunity->isBookable()) {
            return redirect(action('OpportunityController@show', $opportunity));
        }

        return view('opportunity.booking')->with(compact('opportunity'));
    }
}
