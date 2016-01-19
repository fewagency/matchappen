<?php

namespace Matchappen;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

/**
 * @property string token
 * @property string email
 * @property bool is_single_use
 * @property Carbon valid_until
 * @property Model|null object
 * @property string|null object_action
 */
class AccessToken extends Model
{
    use SoftDeletes;
    /**
     * @var string the action for authenticating tokens
     */
    public $token_authentication_action = 'Auth\EmailTokenController@authenticate';

    /**
     * @var string table name for log
     */
    protected $log_table = 'access_token_log';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'valid_until'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_single_use' => 'boolean',
    ];

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (is_null($this->is_single_use)) {
            $this->is_single_use = true;
        }
    }

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

    public function setObjectActionAttribute($action)
    {
        $this->attributes['object_action'] = $action;
        $this->getObjectUrl(); // Called here to validate action with the object
    }

    /**
     * Generate url to the object
     * @return string
     */
    public function getObjectUrl()
    {
        return action($this->object_action, $this->object);
    }

    public function getTokenUrl()
    {
        $parameters['token'] = $this->token;
        if ($this->is_single_use) {
            $parameters['email'] = $this->email;
        }

        return action($this->token_authentication_action, $parameters);
    }

    /**
     * @return bool true if valid time has passed
     */
    public function isExpired()
    {
        return $this->valid_until->isPast();
    }

    /**
     * @return bool true if usage limit not reached for this token
     */
    public function isUsable()
    {
        return !($this->is_single_use and $this->getUsageCount());
    }

    /**
     * @param string $status
     */
    public function logUsage($status)
    {
        $values = [
            'created_at' => Carbon::now(),
            'email' => $this->email,
            'ip' => \Request::getClientIp(),
            'status' => $status
        ];
        if ($this->exists) {
            $values['access_token_id'] = $this->getKey();
        } else {
            $values['token'] = $this->token;
        }
        \DB::table($this->log_table)->insert($values);
    }

    public function getUsageCount()
    {
        return $this->getLogQueryBase()->count();
    }

    public function getUsageData()
    {
        return $this->getLogQueryBase()->get();
    }

    /**
     * @return Builder
     */
    protected function getLogQueryBase()
    {
        return \DB::table($this->log_table)->where('access_token_id', $this->getKey());
    }
}
