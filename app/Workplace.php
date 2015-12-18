<?php

namespace Matchappen;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string name
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
    ];

    /**
     * Scope a query to only include public workplaces for display.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        //TODO: also add "active" scope to avoid listing workplaces whose admins put themselves on hold
        return $query->published();
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
     * @return array of validator rules
     */
    public static function rulesForCreate()
    {
        return [
            'name' => 'required|min:3|max:255|unique:workplaces,name',
            'employees' => 'required|integer|min:1|max:65535',
            'description' => '',
            'homepage' => 'url|max:255',
            'contact_name' => 'max:100',
            'email' => 'email|max:50',
            'phone' => ['max:20', 'regex:/^(\+46 ?|0)[1-9]\d?-?(\d ?){5,}$/'],
            'address' => 'max:500',
        ];
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
