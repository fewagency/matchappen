<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use SoftDeletes;

    //TODO: create occupation_workplace table and relation
    //TODO: create occupation_opportunity table and relation
}
