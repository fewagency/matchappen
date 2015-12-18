<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
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

    public function update(Workplace $workplace)
    {
        //TODO: authorize and validate workplace form input
        //TODO: update workplace
        //TODO: trigger email on workplace update

        return redirect()->action('WorkplaceController@edit', $workplace->getKey());
    }
}