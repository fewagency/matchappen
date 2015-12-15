<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;

class WorkplaceController extends Controller
{
    public function index() {
        return view('workplace.index');
    }
}
