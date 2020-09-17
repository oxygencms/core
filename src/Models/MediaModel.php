<?php

namespace Oxygencms\Core\Models;

use Oxygencms\Core\Traits\MediaMethods;
use Oxygencms\Core\Traits\HasTemporaryMedia;
use Oxygencms\Core\Traits\HasMediaDefinitions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

abstract class MediaModel extends Model implements HasMedia
{
    use HasMediaDefinitions, MediaMethods, InteractsWithMedia, HasTemporaryMedia {
        HasMediaDefinitions::registerMediaCollections insteadof InteractsWithMedia;
        HasMediaDefinitions::registerMediaConversions insteadof InteractsWithMedia;
        HasMediaDefinitions::mapMediaUrls insteadof InteractsWithMedia;
    }
}
