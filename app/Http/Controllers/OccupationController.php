<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Occupation;

class OccupationController extends Controller
{
    public function getList(Request $request)
    {
        $occupations = Occupation::where('name', 'like', $request->get('q') . '%')->orderBy('name')->get();
        if ($request->ajax()) {
            return $occupations;
        }

        return view('occupation.index')->with(compact('occupations'));
    }
}
