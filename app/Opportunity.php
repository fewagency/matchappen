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
 * @property int minutes
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
 * @property int registration_end_weekdays_before
 * @property string name
 * @property Collection occupations
 * @property string timezone
 * @property HostOpportunityEvaluation hostEvaluation
 * @property Collection visitorEvaluations
 */
class Opportunity extends Model
{
    use SoftDeletes;

    const MAX_VISITORS = 30;
    const EARLIEST_HOUR = 8;
    const LATEST_HOUR = 20;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = ['max_visitors' => 5];

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
        'registration_end_weekdays_before',
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
        // These are actual attributes
        'id',
        'max_visitors',
        'description',
        'address',
        'contact_name',
        'contact_phone',
        // These are created by accessors
        'name',
        'href',
        'headline',
        'text',
        'display_address',
        'display_contact_name',
        'display_contact_phone',
        'start_local',
        'start_local_year',
        'start_local_month',
        'start_local_day',
        'start_local_hour',
        'start_local_minute',
        'minutes',
        'registration_end_local',
        'registration_end_weekdays_before',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
        'href',
        'headline',
        'text',
        'display_address',
        'display_contact_name',
        'display_contact_phone',
        'start_local',
        'start_local_year',
        'start_local_month',
        'start_local_day',
        'start_local_hour',
        'start_local_minute',
        'minutes',
        'registration_end_local',
        'registration_end_weekdays_before',
    ];

    public function __construct(array $attributes = [])
    {
        $default_start_local = Carbon::parse('+30 weekdays 15:00', $this->timezone);
        $this->attributes['start'] = $this->asDateTime(Carbonator::parseToDefaultTz($default_start_local));
        $this->attributes['end'] = $this->asDateTime(Carbonator::parseToDefaultTz($default_start_local->copy()->addHour()));

        parent::__construct($attributes);

        if (empty($this->registration_end)) {
            $this->registration_end =
                Carbonator::parseToDefaultTz($this->start_local->subWeekdays(5)->minute(0), $this->timezone);
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

    /**
     * The host evaluation of this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hostEvaluation()
    {
        return $this->hasOne('Matchappen\HostOpportunityEvaluation');
    }

    /**
     * The visitor evaluations for this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function visitorEvaluations()
    {
        return $this->hasManyThrough('Matchappen\VisitorOpportunityEvaluation', 'bookings');
    }

    public static function getTimezoneAttribute()
    {
        return 'Europe/Stockholm';
    }

    public function setStartAttribute($value)
    {
        // Save data to move the end time and registration end time along with the start time
        $minutes = $this->minutes;
        $registration_end_weekdays_before = $this->registration_end_weekdays_before;

        $this->attributes['start'] = $this->fromDateTime($value);

        $this->minutes = $minutes;
        $this->registration_end_weekdays_before = $registration_end_weekdays_before;
    }

    public function getStartLocalAttribute()
    {
        return Carbonator::parseToTz($this->start, $this->timezone);
    }

    public function setStartLocalAttribute($datetime)
    {
        $this->start = Carbonator::parseToDefaultTz($datetime, $this->timezone);
    }

    public function getStartLocalYearAttribute()
    {
        return $this->start_local->format('Y');
    }

    public function getStartLocalMonthAttribute()
    {
        return $this->start_local->format('m');
    }

    public function getStartLocalDayAttribute()
    {
        return $this->start_local->format('d');
    }

    public function getStartLocalHourAttribute()
    {
        return $this->start_local->format('H');
    }

    public function getStartLocalMinuteAttribute()
    {
        return $this->start_local->format('i');
    }

    public function getMinutesAttribute()
    {
        if (empty($this->start) or empty($this->end)) {
            return 60;
        }

        return $this->start->diffInMinutes($this->end);
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

    public function getRegistrationEndWeekdaysBeforeAttribute()
    {
        return $this->registration_end_local->startOfDay()->diffInWeekdays($this->start_local->startOfDay());
    }

    public function setRegistrationEndWeekdaysBeforeAttribute($weekdays)
    {
        $weekdays = abs($weekdays);
        $value = $this->start_local;
        if ($weekdays) {
            $value->subWeekdays($weekdays);
        }
        // Set to the nearest hour before start time of day
        $value->hour($this->start_local->hour)->minute($this->start_local->minute);
        $value->subMinute();
        $value->minute(0);

        $this->registration_end_local = $value;
    }

    public function getDisplayAddressAttribute()
    {
        return $this->address ?: $this->fallback_address;
    }

    public function getFallbackAddressAttribute()
    {
        if ($this->workplace) {
            return $this->workplace->address;
        }

        return null;
    }

    public function getDisplayContactNameAttribute()
    {
        return $this->contact_name ?: $this->fallback_contact_name;
    }

    public function getFallbackContactNameAttribute()
    {
        if ($this->workplace) {
            return $this->workplace->display_contact_name;
        }

        return null;
    }

    public function getDisplayContactPhoneAttribute()
    {
        return $this->contact_phone ?: $this->fallback_contact_phone;
    }

    public function getFallbackContactPhoneAttribute()
    {
        if ($this->workplace) {
            return $this->workplace->display_phone;
        }

        return null;
    }

    public function getNameAttribute()
    {
        if ($this->workplace) {
            return trans('opportunity.opportunity_at_workplace',
                [
                    'workplace' => $this->workplace->name,
                    'time' => $this->start_local->format('j/n G:i'),
                ]);
        }

        return null;
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
        return $this->workplace ? $this->workplace->isPublished() : false;
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

    /**
     * Get options for a start year dropdown
     * @return array
     */
    public static function getStartTimeYearOptions()
    {
        $year_range = range(self::getEarliestStartTimeLocal()->year, self::getLatestStartTimeLocal()->year);

        return array_combine($year_range, $year_range);
    }

    /**
     * Get options for a start hour dropdown
     * @return array
     */
    public static function getStartTimeHourOptions()
    {
        $hours_range = range(self::EARLIEST_HOUR, self::LATEST_HOUR);
        $formatted_hours = array_map(function ($day) {
            return str_pad($day, 2, '0', STR_PAD_LEFT);
        }, $hours_range);

        return array_combine($formatted_hours, $formatted_hours);
    }

    /**
     * Get options for a start minute dropdown
     * @return array
     */
    public static function getStartTimeMinuteOptions()
    {
        return ['00' => '00', '15' => '15', '30' => '30', '45' => '45'];
    }

    /**
     * Get a student's booking on this opportunity - if student has a booking
     * @param $student_email
     * @return Booking|null
     */
    public function getBookingForStudent($student_email)
    {
        return $this->bookings->first(function ($key, Booking $booking) use ($student_email) {
            return $booking->checkVisitorEmail($student_email);
        });
    }

    /**
     * Get the saved host evaluation or a new evaluation if the supplied user is admin of the opportunity
     * @param User $user
     * @return HostOpportunityEvaluation|null
     */
    public function getHostEvaluationForUser(User $user)
    {
        if ($user->workplace_id === $this->workplace_id) {
            if ($this->hostEvaluation) {
                return $this->hostEvaluation;
            }
            $evaluation = new HostOpportunityEvaluation();
            $evaluation->opportunity()->associate($this);
            $evaluation->user()->associate($user);

            return $evaluation;
        }

        return null;
    }

    /**
     * Get the saved evaluation for a visitor's email or create a new one if the visitor had a booking
     * @param $student_email
     * @return VisitorOpportunityEvaluation|null
     */
    public function getVisitorEvaluationForEmail($student_email)
    {
        if ($booking = $this->getBookingForStudent($student_email)) {
            if ($booking->visitorEvaluation) {
                return $booking->visitorEvaluation;
            }
            $evaluation = new VisitorOpportunityEvaluation();
            $evaluation->booking()->associate($booking);

            return $evaluation;
        }

        return null;
    }
}
