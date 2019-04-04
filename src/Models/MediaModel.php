<?php

namespace Oxygencms\Core\Models;

use Oxygencms\Core\Traits\MediaMethods;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Oxygencms\Core\Traits\HasTemporaryMedia;
use Oxygencms\Core\Traits\HasMediaDefinitions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

abstract class MediaModel extends Model implements HasMedia
{
    use HasMediaDefinitions, MediaMethods, HasMediaTrait, HasTemporaryMedia {
        HasMediaDefinitions::registerMediaCollections insteadof HasMediaTrait;
        HasMediaDefinitions::registerMediaConversions insteadof HasMediaTrait;
        HasMediaDefinitions::mapMediaUrls insteadof HasMediaTrait;
    }

    /**
     * @param array $attributes
     * @param int|null $temporary_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [], int $temporary_id = null)
    {
        $model = parent::query()->create($attributes);

        if($temporary_id) {
            self::moveMedia($model, $temporary_id);
        }

        return $model;
    }
}
