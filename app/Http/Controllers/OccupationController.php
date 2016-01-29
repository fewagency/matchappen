<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Occupation;

class OccupationController extends Controller
{
    public function index(Request $request)
    {
        $occupations = Occupation::where('name', 'like', $request->get('q') . '%')->orderBy('name')->get();
        if ($request->ajax()) {
            return $occupations;
        }

        return view('occupation.index')->with(compact('occupations'));
    }

    public function show(Occupation $occupation)
    {
        return view('occupation.show')->with(compact('occupation'));
    }

}
