<?php

namespace Matchappen;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Carbon|null reserved_until Soft-delete instances where this time has passed
 * @property string name of the visitor - or the supervisor if booking for a group
 * @property integer visitors >1 if booking is for a group
 * @property string|null email Email to the booked student
 * @property string supervisor_email
 * @property string|null phone to the visitor
 * @property Collection access_tokens generated for this Booking
 * @property Opportunity opportunity
 */
class Booking extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'reserved_until'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'visitors',
        'email',
        'supervisor_email',
        'phone',
    ];

    public function generateAccessToken($email, Carbon $valid_until = null)
    {
        $token = new AccessToken(['email' => $email, 'valid_until' => $valid_until ?: $this->reserved_until]);
        $token->object_action = 'BookingController@show';

        return $this->accessTokens()->save($token) ? $token : false;
    }

    /**
     * Relation to the Opportunity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opportunity()
    {
        return $this->belongsTo('Matchappen\Opportunity');
    }

    /**
     * Relation to access tokens
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    protected function accessTokens()
    {
        return $this->morphMany('Matchappen\AccessToken', 'object');
    }

    /**
     * @return bool true if this booking is for a group
     */
    public function isGroup()
    {
        return $this->visitors > 1;
    }

    /**
     * @return bool true if this booking is confirmed, by visitor or supervisor
     */
    public function isConfirmed()
    {
        return $this->exists and !$this->reserved_until;
    }

    /**
     * Determine if the supplied email address is related to the booking.
     *
     * @param string $email
     * @return bool
     */
    public function checkEmail($email)
    {
        return $this->checkVisitorEmail($email) or $this->checkSupervisorEmail($email);
    }

    /**
     * Determine if the supplied email address matches the visitor address
     *
     * @param string $email
     * @return bool
     */
    public function checkVisitorEmail($email)
    {
        return $this->email === $email;
    }

    /**
     * Determine if the supplied email address matches the supervisor address
     *
     * @param string $email
     * @return bool
     */
    public function checkSupervisorEmail($email)
    {
        return $this->supervisor_email === $email;
    }

    /**
     * Mark this booking as confirmed by visitor
     */
    public function confirm()
    {
        if ($this->exists and !$this->isConfirmed()) {
            $this->reserved_until = null;
            $this->save();
        }
    }

    /**
     * Soft-delete this booking if its reservation is no longer valid
     */
    public function clearIfExpired()
    {
        if ($this->isExpired() and $this->exists) {
            $this->delete();
        }
    }

    /**
     * @return bool true if reservation time has passed
     */
    public function isExpired()
    {
        return $this->reserved_until and $this->reserved_until->isPast();
    }

    /**
     * @return bool true if the booking can be cancelled
     */
    public function isCancelable()
    {
        return !$this->opportunity->isRegistrationClosed();
    }

    /**
     * Scope a query to only include bookings for a specified supervisor.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForSupervisor($query, $email)
    {
        return $query->confirmed()->where('supervisor_email', $email);
    }

    /**
     * Scope a query to only include bookings for a specified student.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForStudent($query, $email)
    {
        return $query->where('email', $email);
    }

    /**
     * Scope a query to only include confirmed bookings.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConfirmed($query)
    {
        return $query->where('reserved_until', null);
    }

    /**
     * Scope a query to only include bookings with opportunities in the future.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->whereHas('opportunity', function ($query) {
            $query->upcoming();
        });
    }

    /**
     * Scope a query to only include bookings for opportunities in the past.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePassed($query)
    {
        return $query->whereHas('opportunity', function ($query) {
            $query->passed();
        });
    }

    /**
     * Scope a query to only include bookings with opportunities in the recent past.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentlyPassed($query)
    {
        return $query->whereHas('opportunity', function ($query) {
            $query->recentlyPassed();
        });
    }
}
