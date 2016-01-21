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
 * @property Collection opportunities
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
 * @property bool|null is_published
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
     * Publish this workplace - to be used by admins
     */
    public function publish()
    {
        if($this->exists) {
            $this->is_published = true;
            $this->save();
        }
    }

    /**
     * Unpublish this workplace to hide it from the front-end of the app
     */
    public function unpublish()
    {
        if($this->exists) {
            $this->is_published = false;
            $this->save();
        }
    }

    /**
     * Request this workplace to be published by an admin
     */
    public function requestPublish()
    {
        if($this->exists) {
            $this->is_published = null;
            $this->save();
        }
    }

    /**
     * @return bool true if workplace is published for display on the front-end of the app
     */
    public function isPublished()
    {
        return (bool)$this->is_published;
    }

    /**
     * @return bool true if workplace is requested to be published by admin
     */
    public function isPublishRequested()
    {
        return is_null($this->is_published);
    }

    /**
     * Scope a query to only include published workplaces.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include workplaces waiting for publication.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublishRequested($query)
    {
        return $query->where('is_published', null);
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

    /**
     * The users connected to this workplace
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('Matchappen\User');
    }

    /**
     * The opportunities of this workplace
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opportunities()
    {
        return $this->hasMany('Matchappen\Opportunity');
    }

    /**
     * The future opportunities of this workplace
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function upcomingOpportunities()
    {
        return $this->opportunities()->upcoming();
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
