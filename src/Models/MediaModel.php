<?php

namespace Oxygencms\Core\Models;

use Oxygencms\Core\Traits\MediaMethods;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Oxygencms\Core\Traits\HasMediaDefinitions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

abstract class MediaModel extends Model implements HasMedia
{
    use HasMediaDefinitions, MediaMethods, HasMediaTrait {
        HasMediaDefinitions::registerMediaCollections insteadof HasMediaTrait;
        HasMediaDefinitions::registerMediaConversions insteadof HasMediaTrait;
        HasMediaDefinitions::mapMediaUrls insteadof HasMediaTrait;
    }
}
