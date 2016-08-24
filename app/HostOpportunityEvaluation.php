<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int rating
 * @property string comment
 * @property User user
 * @property Opportunity opportunity
 */
class HostOpportunityEvaluation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating',
        'comment',
    ];

    /**
     * The Opportunity related to this evaluation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opportunity()
    {
        return $this->belongsTo('Matchappen\Opportunity');
    }

    /**
     * The User that filled in the evaluation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Matchappen\User');
    }
}
