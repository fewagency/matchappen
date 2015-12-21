<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreWorkplaceRequest;
use Matchappen\Workplace;

class WorkplaceController extends Controller
{
    public function index()
    {
        $workplaces = Workplace::published()->get();

        return view('workplace.index')->with(compact('workplaces'));
    }

    public function show(Workplace $workplace)
    {
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