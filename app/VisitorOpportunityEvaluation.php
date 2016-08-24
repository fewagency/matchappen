<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int rating
 * @property string comment
 * @property Booking booking
 * @property Opportunity opportunity
 */
class VisitorOpportunityEvaluation extends Model
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
     * The Booking related to this evaluation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo('Matchappen\Booking');
    }

    /**
     * The Opportunity related to this evaluation
     * @return Opportunity
     */
    public function opportunity()
    {
        return $this->booking->opportunity;
    }
}
