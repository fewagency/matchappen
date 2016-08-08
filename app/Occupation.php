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
    protected $visible = ['id', 'name', 'slug', 'href', 'headline', 'text'];

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
     * The future opportunities of this occupation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function upcomingOpportunities()
    {
        return $this->opportunities()->upcoming();
    }

    /**
     * Relationship to the user that created this occupation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('Matchappen\User', 'created_by');
    }

    /**
     * Scope a query to only include occupations from published workplaces.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereHas('workplaces', function ($query) {
            $query->published();
        });
    }

    /**
     * Scope a query to only include occupations to promote.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePromoted($query)
    {
        return $query->whereHas('opportunities', function ($query) {
            $query->bookable();
        });
        //promoted occupations could be ordered by number of bookable opportunities
    }

    public function getHrefAttribute()
    {
        return action('OccupationController@show', $this);
    }

    public function getHeadlineAttribute()
    {
        return $this->name;
    }

    public function getTextAttribute()
    {
        $offers = [];
        $workplace_count = $this->workplaces()->published()->count();
        $opportunity_count = $this->opportunities()->viewable()->count();
        if ($workplace_count) {
            $offers[] = $workplace_count . ' ' . trans_choice('workplace.workplace', $workplace_count);
        }
        if ($opportunity_count) {
            $offers[] = $opportunity_count . ' ' . trans_choice('opportunity.opportunity', $opportunity_count);
        }

        return implode(', ', $offers);
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
     * @param array $names
     * @param User|null $user
     * @return Collection
     */
    public static function getOrCreateFromNames($names, User $user)
    {
        $names = collect($names);
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

            return $existing;
        }

        return $existing;
    }

    /**
     * @param string $names
     * @param User|null $user
     * @return Collection
     */
    public static function getOrCreateFromCommaSeparatedNames($names, User $user = null)
    {
        $names = collect(explode(',', $names))->map(function ($item) {
            //strip any multiple non-word chars from occupation name
            return trim(preg_replace('/(\W)\1+/', '$1', $item));
        })->filter();
        $existing = self::getOrCreateFromNames($names, $user);

        return $existing;
    }
}
