<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property string token
 * @property string email
 */
class AccessToken extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'valid_until'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'valid_until',
        'is_single_use',
        'object_action',
    ];

    /**
     * Relation to the object this token is valid for
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function object()
    {
        return $this->morphTo();
    }

    /**
     * @return bool true if unique token successfully generated
     */
    public function generateToken()
    {
        do {
            // This hashing is inspired by \Illuminate\Auth\Passwords\DatabaseTokenRepository::createNewToken()
            $this->token = hash_hmac('sha256', Str::random(40), config('app.key'));
        } while (AccessToken::where(['email' => $this->email, 'token' => $this->token])->count());

        return (bool)$this->email;
    }
}
