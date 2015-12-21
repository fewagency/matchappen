<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int workplace_id
 */
class Opportunity extends Model
{
    use SoftDeletes;

    const MAX_VISITORS = 30;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'max_visitors',
        'description',
    ];

    /**
     * Scope a query to only include opportunities from published workplaces.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereHas('workplace', function ($query) {
            $query->published();
        });
    }

    /**
     * The workplace of this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workplace()
    {
        return $this->belongsTo('Matchappen\Workplace');
    }

    public function getNameAttribute()
    {
        return trans('general.oportunity_at_workplace', ['workplace' => $this->workplace->name]);
    }

}
