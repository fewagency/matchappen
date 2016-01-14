<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreWorkplaceRequest;
use Matchappen\Workplace;

class WorkplaceController extends Controller
{

    public function __construct(Request $request)
    {
        $fields_to_trim = array_keys(StoreWorkplaceRequest::rulesForUpdate());
        $this->middleware('input.trim:' . implode(',', $fields_to_trim), ['only' => 'update']);
    }

    public function index()
    {
        $workplaces = Workplace::published()->get();

        return view('workplace.index')->with(compact('workplaces'));
    }

    public function show(Workplace $workplace)
    {
        if (!$workplace->isPublished()) {
            return redirect(action('WorkplaceController@index'));
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

        //TODO: trigger email on workplace update

        return redirect()->action('WorkplaceController@edit', $workplace->getKey());
    }
}