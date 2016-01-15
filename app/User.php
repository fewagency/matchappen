<?php

namespace Matchappen;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @property bool is_admin
 * @property int workplace_id
 * @property Workplace workplace
 * @property string name
 * @property string email
 * @property string phone
 */
class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'phone'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The workplace of this user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workplace()
    {
        return $this->belongsTo('Matchappen\Workplace');
    }

    /**
     * @return array of validator rules
     */
    public static function rulesForCreate()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:' . trans('general.local_phone_regex')],
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'phone' => ['required', 'string', 'max:20', 'regex:' . trans('general.local_phone_regex')],
        ];
    }
}
