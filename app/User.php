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
            'name' => 'max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => ['max:20', 'regex:/^(\+46 ?|0)[1-9]\d?-?(\d ?){5,}$/'],
        ];
    }
}
