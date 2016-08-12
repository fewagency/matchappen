<?php

namespace Matchappen;

use Carbon\Carbon;
use FewAgency\Carbonator\Carbonator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Expression;

/**
 * @property int workplace_id
 * @property int max_visitors
 * @property Carbon start
 * @property Carbon start_local
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
 * @property Collection bookings
 * @property Carbon registration_end
 * @property Carbon registration_end_local
 * @property string name
 * @property Collection occupations
 * @property string timezone
 */
class Opportunity extends Model
{
    use SoftDeletes;

    const MAX_VISITORS = 30;
    const EARLIEST_HOUR = 8;
    const LATEST_HOUR = 20;

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
        'start_local',
        'minutes',
        'registration_end_local',
        'address',
        'contact_name',
        'contact_phone',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'href',
        'headline',
        'text',
        'max_visitors',
        'start_local',
        'minutes',
        'registration_end_local',
        'description',
        'address',
        'display_address',
        'contact_name',
        'display_contact_name',
        'contact_phone',
        'display_contact_phone',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if(empty($this->start)) {
            $this->start = Carbonator::parseToDefaultTz('+30 weekdays 15:00', $this->timezone);
        }
        if(empty($this->registration_end)) {
            $this->registration_end = Carbonator::parseToDefaultTz($this->start_local->subWeekdays(7)->minute(0), $this->timezone);
        }
    }

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
     * Scope a query to only include opportunities in the future.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start', '>', Carbon::now());
    }

    /**
     * Scope a query to only include opportunities in the past.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePassed($query)
    {
        return $query->where('start', '<', Carbon::now())->orderBy('start', 'desc');
    }

    /**
     * Scope a query to only include opportunities in the recent past.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentlyPassed($query)
    {
        return $query->passed()->where('start', '>', Carbon::parse('-1 month'));
    }

    /**
     * Scope a query to only include opportunities that can be viewed by front-end visitors.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeViewable($query)
    {
        return $query->published()->upcoming();
    }

    /**
     * Scope a query to only include opportunities that have places left to book
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPlacesLeft($query)
    {
        //check for max_visitors > (select sum(bookings.visitors) from bookings where...)
        $query->where('max_visitors', '>', function (\Illuminate\Database\Query\Builder $query) {
            $related_model = $this->bookings()->getRelated();
            $query->from($related_model->getTable());
            $related_model->applyGlobalScopes($related_model->newEloquentBuilder($query));
            $query->select(new Expression('coalesce(sum(visitors), 0)'))
                ->where($this->getQualifiedKeyName(), new Expression($this->bookings()->getForeignKey()));
        });

        return $query;
    }

    /**
     * Scope a query to only include opportunities that can be booked by front-end visitors.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBookable($query)
    {
        return $query->where('registration_end', '>', Carbon::now())->withPlacesLeft()->viewable();
    }

    /**
     * Scope a query to only include opportunites to promote.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePromoted($query)
    {
        return $query->bookable()->orderBy('registration_end');
    }

    /**
     * The workplace of this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workplace()
    {
        return $this->belongsTo('Matchappen\Workplace');
    }

    /**
     * The occupations relevant for this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function occupations()
    {
        return $this->belongsToMany('Matchappen\Occupation');
    }

    /**
     * The bookings made on this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany('Matchappen\Booking');
    }

    public static function getTimezoneAttribute()
    {
        return 'Europe/Stockholm';
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $this->fromDateTime($value);

        if (empty($this->end) or $this->start->gte($this->end)) {
            $this->end = $this->start->addHour();
        }
        if (empty($this->registration_end) or $this->start->lte($this->registration_end)) {
            $this->registration_end = $this->start->subHour();
        }
    }

    public function getStartLocalAttribute()
    {
        return Carbonator::parseToTz($this->start, $this->timezone);
    }

    public function setStartLocalAttribute($datetime)
    {
        $this->start = Carbonator::parseToDefaultTz($datetime, $this->timezone);
    }

    public function getMinutesAttribute()
    {
        if (!empty($this->start)) {
            return $this->start->diffInMinutes($this->end);
        }
    }

    public function setMinutesAttribute($minutes)
    {
        $this->end = $this->start->addMinutes($minutes);
    }

    public function getRegistrationEndLocalAttribute()
    {
        return Carbonator::parseToTz($this->registration_end, $this->timezone);
    }

    public function setRegistrationEndLocalAttribute($datetime)
    {
        $this->registration_end = Carbonator::parseToDefaultTz($datetime, $this->timezone);
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
        return trans('opportunity.opportunity_at_workplace',
            [
                'workplace' => $this->workplace->name,
                'time' => $this->start_local->format('j/n G:i'),
            ]);
    }

    public function getHrefAttribute()
    {
        return action('OpportunityController@show', $this);
    }

    public function getHeadlineAttribute()
    {
        return $this->name;
    }

    public function getTextAttribute()
    {
        $parts = [];
        if ($this->occupations->count()) {
            $parts[] = $this->occupations->implode('name', ', ');
        }

        return implode(' - ', $parts);
    }

    public function numberOfBookedVisitors()
    {
        $this->clearExpiredBookings();

        return $this->bookings()->sum('visitors');
    }

    public function isPublished()
    {
        return $this->workplace->isPublished();
    }

    public function isUpcoming()
    {
        return $this->start->isFuture();
    }

    public function isPassed()
    {
        return $this->start->isPast();
    }

    public function isViewable()
    {
        return $this->isPublished() and $this->isUpcoming();
    }

    public function placesLeft()
    {
        return max(0, $this->max_visitors - $this->numberOfBookedVisitors());
    }

    public function hasPlacesLeft()
    {
        return $this->placesLeft() > 0;
    }

    public function isBookable()
    {
        return !$this->isRegistrationClosed() and $this->hasPlacesLeft();
    }

    public function clearExpiredBookings()
    {
        $this->bookings->each(function (Booking $booking) {
            $booking->clearIfExpired();
        });
    }

    public function isRegistrationClosed()
    {
        return $this->registration_end->isPast();
    }

    /**
     * Get the earliest possible start time relative now
     * @return Carbon
     */
    public static function getEarliestStartTimeLocal()
    {
        return Carbon::parse('+2 hours', self::getTimezoneAttribute())->minute(0)->second(0);
    }

    /**
     * Get the latest possible start time relative now
     * @return Carbon
     */
    public static function getLatestStartTimeLocal()
    {
        return Carbon::parse('+6 months 00:00', self::getTimezoneAttribute());
    }

    public static function getStartTimeYearOptions()
    {
        $year_range = range(self::getEarliestStartTimeLocal()->year, self::getLatestStartTimeLocal()->year);

        return array_combine($year_range, $year_range);
    }

    public static function getStartTimeHourOptions()
    {
        $hours_range = range(self::EARLIEST_HOUR, self::LATEST_HOUR);
        $formatted_hours = array_map(function ($day) {
            return str_pad($day, 2, '0', STR_PAD_LEFT);
        }, $hours_range);

        return array_combine($formatted_hours, $formatted_hours);
    }

    public static function getStartTimeMinuteOptions()
    {
        return ['00' => '00', '15' => '15', '30' => '30', '45' => '45'];
    }
}
