<?php

namespace Matchappen;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string name
 * @property Collection users
 * @property string address
 * @property string email
 * @property string display_email
 * @property string fallback_email
 * @property string contact_name
 * @property string display_contact_name
 * @property string fallback_contact_name
 * @property string phone
 * @property string display_phone
 * @property string fallback_phone
 * @property string homepage
 */
class Workplace extends Model implements SluggableInterface
{
    use SoftDeletes, SluggableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'employees',
        'description',
        'homepage',
        'contact_name',
        'email',
        'phone',
        'address',
        'homepage',
    ];

    /**
     * Scope a query to only include published workplaces.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getDisplayContactNameAttribute()
    {
        return $this->contact_name ?: $this->fallback_contact_name;
    }

    public function getFallbackContactNameAttribute()
    {
        return $this->users->first()->name;
    }

    public function getDisplayEmailAttribute()
    {
        return $this->email ?: $this->fallback_email;
    }

    public function getFallbackEmailAttribute()
    {
        return $this->users->first()->email;
    }

    public function getDisplayPhoneAttribute()
    {
        return $this->phone ?: $this->fallback_phone;
    }

    public function getFallbackPhoneAttribute()
    {
        return $this->users->first()->phone;
    }

    public function users()
    {
        return $this->hasMany('Matchappen\User');
    }

    public function getRouteKeyName()
    {
        $config = $this->getSluggableConfig();

        return $config['save_to'];
    }

    public function __toString()
    {
        return $this->name;
    }


}
