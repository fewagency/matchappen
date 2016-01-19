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
 * @property string|null email Email to the booked pupil
 * @property string supervisor_email
 * @property string|null phone to the visitor
 * @property Collection access_tokens generated for this Booking
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

    public function isGroup()
    {
        return $this->visitors > 1;
    }

    /**
     * Determine if the supplied email address is related to the booking.
     *
     * @param string $email
     * @return bool
     */
    public function checkEmail($email) {
        return $this->email === $email or $this->supervisor_email === $email;
    }

    // TODO: create accessor for visitor_name on Booking
}
