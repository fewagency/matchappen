<?php

namespace Matchappen;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int workplace_id
 * @property Carbon start
 * @property Carbon end
 */
class Opportunity extends Model
{
    use SoftDeletes;

    const MAX_VISITORS = 30;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'start', 'end', 'registration_end'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'max_visitors',
        'description',
        'start',
        'minutes',
        'registration_end',
        'address',
        'contact_name',
        'contact_phone',
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

    public function setStartAttribute($datetime) {
        $this->attributes['start'] = Carbon::parse($datetime);
    }

    public function getMinutesAttribute() {
        return $this->start->diffInMinutes($this->end);
    }

    public function setMinutesAttribute($minutes) {
        $this->end = $this->start->copy()->addMinutes($minutes);
    }

    public function setRegistrationEndAttribute($datetime) {
        $this->attributes['registration_end'] = Carbon::parse($datetime);
    }

    public function getNameAttribute()
    {
        return trans('general.oportunity_at_workplace',
            [
                'workplace' => $this->workplace->name,
                'time' => $this->start->format('j/n G:i'),
            ]);
    }

}
