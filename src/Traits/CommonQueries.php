<?php

namespace Oxygencms\Core\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CommonQueries
{
    /**
     * Appends accessors to all models and relations. Optionally
     * pass relations to be eager loaded as second argument.
     * Not appending accessors? Serialize the results...
     *
     * @param mixed $accessors
     * @param mixed $relations
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function allWithAccessors($accessors, $relations = [])
    {
        return self::with($relations)->get()->each(function ($model) use ($accessors, $relations) {

            $model->append($accessors);

            // skip the rest if no relations were passed
            if (empty($relations)) {
                return true;
            }

            // append to related models
            if (is_string($relations)) {
                $model->{$relations}->each->append($accessors);
            } else {
                foreach ($relations as $relation) {
                    $model->{$relation}->each->append($accessors);
                }
            }
        });
    }

    /**
     * Scope a query to only include active models.
     *
     * @param Builder $query
     *
     * @return Builder $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', 1);
    }
}