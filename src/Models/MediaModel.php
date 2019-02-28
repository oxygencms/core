<?php

namespace Oxygencms\Core\Models;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Oxygencms\Core\Traits\HasMediaDefinitions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

abstract class MediaModel extends Model implements HasMedia
{
    use HasMediaDefinitions, HasMediaTrait {
        HasMediaDefinitions::registerMediaCollections insteadof HasMediaTrait;
        HasMediaDefinitions::registerMediaConversions insteadof HasMediaTrait;
        HasMediaDefinitions::mapMediaUrls insteadof HasMediaTrait;
    }
}
