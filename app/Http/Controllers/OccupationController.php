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
        $query = Occupation::query();

        if ($request->has('q')) {
            $query->where('name', 'like', $request->get('q') . '%');
        }

        if ($request->ajax()) {
            $query->orderBy('name');

            return $query->get();
        }

        $query->published();

        return view('occupation.index')->with(['occupations' => $query->get()]);
    }

    public function show(Occupation $occupation)
    {
        return view('occupation.show')->with(compact('occupation'));
    }

}
