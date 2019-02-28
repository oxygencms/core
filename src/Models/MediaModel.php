<?php

namespace Oxygencms\Core\Models;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

abstract class MediaModel extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        foreach (config('oxygen.image_conversions') as $conversion => $width) {
            $this->addMediaConversion($conversion)
                 ->width($width)
                 ->performOnCollections('images')
                 ->nonQueued();
        }
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('images')->acceptsFile(function ($file) {
            return in_array($file->mimeType, config('oxygen.image_types'));
        });

        $this->addMediaCollection('videos')->acceptsFile(function ($file) {
            return in_array($file->mimeType, config('oxygen.video_types'));
        });
    }

    public function mapMediaUrls()
    {
        $this->load('media');

        $this->media->map(function ($media) {
            $media->url = $media->getFullUrl();
        });
    }
}
