<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use SoftDeletes;

    public function workplaces()
    {
        return $this->belongsToMany('Matchappen\Workplace');
    }

    public function opportunities()
    {
        return $this->belongsToMany('Matchappen\Opportunity');
    }
}
