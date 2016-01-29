<?php

namespace Matchappen;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string name
 */
class Occupation extends Model implements SluggableInterface
{
    use SoftDeletes, SluggableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['id', 'name'];

    /**
     * Relationship to workplaces where this occupation is represented
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workplaces()
    {
        return $this->belongsToMany('Matchappen\Workplace');
    }

    /**
     * Relationship to opportunities relevant for this occupation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function opportunities()
    {
        return $this->belongsToMany('Matchappen\Opportunity');
    }

    /**
     * Relationship to the user that created this occupation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('Matchappen\User', 'created_by');
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

    /**
     * @param string $names
     * @param User|null $user
     * @return Collection
     */
    public static function getOrCreateFromCommaSeparatedNames($names, User $user = null)
    {
        $names = collect(explode(',', $names))->map(function ($item) {
            return trim($item);
        })->filter();
        $instance = new static;
        $existing = $instance->newQuery()->whereIn('name', $names)->get();
        if ($user and $user->exists) {
            $names->diff($existing->pluck('name'))->each(function ($name) use ($existing, $user) {
                if (mb_strlen($name) < 4) {
                    //Don't add names shorter than 4 chars
                    return;
                }
                $new = new self(compact('name'));
                $new->createdBy()->associate($user);
                $new->save();

                $existing->push($new);
            });
        }

        return $existing;
    }
}
