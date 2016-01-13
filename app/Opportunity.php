<?php

namespace Matchappen;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int workplace_id
 * @property Carbon start
 * @property Carbon end
 * @property Workplace workplace
 * @property string address
 * @property string display_address
 * @property string fallback_address
 * @property string contact_name
 * @property string display_contact_name
 * @property string fallback_contact_name
 * @property string contact_phone
 * @property string display_contact_phone
 * @property string fallback_contact_phone
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

    public function setStartAttribute($datetime)
    {
        $this->attributes['start'] = Carbon::parse($datetime);
    }

    public function getMinutesAttribute()
    {
        if (empty($this->start)) {
            return;
        }

        return $this->start->diffInMinutes($this->end);
    }

    public function setMinutesAttribute($minutes)
    {
        $this->end = $this->start->copy()->addMinutes($minutes);
    }

    public function setRegistrationEndAttribute($datetime)
    {
        $this->attributes['registration_end'] = Carbon::parse($datetime);
    }

    public function getDisplayAddressAttribute()
    {
        return $this->address ?: $this->fallback_address;
    }

    public function getFallbackAddressAttribute()
    {
        return $this->workplace->address;
    }

    public function getDisplayContactNameAttribute()
    {
        return $this->contact_name ?: $this->fallback_contact_name;
    }

    public function getFallbackContactNameAttribute()
    {
        return $this->workplace->display_contact_name;
    }

    public function getDisplayContactPhoneAttribute()
    {
        return $this->contact_phone ?: $this->fallback_contact_phone;
    }

    public function getFallbackContactPhoneAttribute()
    {
        return $this->workplace->display_phone;
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
