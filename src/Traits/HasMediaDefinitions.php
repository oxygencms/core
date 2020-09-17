<?php

namespace Oxygencms\Core\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMediaDefinitions
{
    /**
     * Register media conversions.
     *
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // Images Collection
        foreach (config('oxygen.image_conversions') as $conversion => $width) {
            $this->addMediaConversion($conversion)
                 ->width($width)
                 ->performOnCollections('images')
                 ->nonQueued();
        }

        // Image Collection
        $this->addMediaConversion('xs')
             ->width(config('oxygen.image_conversions.xs'))
             ->performOnCollections('image')
             ->nonQueued();
    }

    /**
     * Register media collections.
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     */
    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('image')->singleFile()->acceptsFile(function ($file) {
            return in_array($file->mimeType, config('oxygen.image_types'));
        });

        $this->addMediaCollection('images')->acceptsFile(function ($file) {
            return in_array($file->mimeType, config('oxygen.image_types'));
        });

        $this->addMediaCollection('videos')->acceptsFile(function ($file) {
            return in_array($file->mimeType, config('oxygen.video_types'));
        });
    }

    /**
     * Append the full urls to all media items in the collection.
     *
     */
    public function mapMediaUrls()
    {
        $this->load('media');

        $this->media->map(function ($media) {
            $media->url = $media->getFullUrl();
        });
    }
}
