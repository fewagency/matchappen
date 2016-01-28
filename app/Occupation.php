<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use SoftDeletes;

    /**
     * Relationship to workplaces where this occupation is represented
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workplaces()
    {
        return $this->belongsToMany('Matchappen\Workplace');
    }

    /**
     * Relationship to opportunities relevant for this occupation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function opportunities()
    {
        return $this->belongsToMany('Matchappen\Opportunity');
    }

    /**
     * Relationship to the user that created this occupation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy() {
        return $this->belongsTo('Matchappen\User');
    }
}
