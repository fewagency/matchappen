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
        //TODO: implement scope via relation to workplace
        return $query->where('is_published', true);
    }

    /**
     * The workplace of this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workplace()
    {
        return $this->belongsTo('Matchappen\Workplace');
    }

}
