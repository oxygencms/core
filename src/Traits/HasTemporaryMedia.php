<?php

namespace Oxygencms\Core\Traits;

use Oxygencms\Core\Models\Temporary;

trait HasTemporaryMedia
{
    /**
     * Move the media from the temporary models to the created model and delete the temporary model
     *
     * @param $entity
     * @param int $temporary_id
     */
    public static function moveMedia($entity, int $temporary_id)
    {
        $temporary = Temporary::findOrFail($temporary_id);

        $media = $temporary->media;

        $media->each(function ($item) use($entity) {
            $item->move($entity, $item->collection_name);
        });

        $temporary->delete();
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {
        $model = parent::query()->create($attributes);

        if (request()->has('temporary_id')) {
            self::moveMedia($model, request('temporary_id'));
        }

        return $model;
    }
}