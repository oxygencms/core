<?php

namespace Oxygencms\Core\Traits;

use Spatie\MediaLibrary\Models\Media;

trait HasMediaDefinitions
{
    /**
     * Register media conversions.
     *
     * @param Media|null $media
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
     * Register media collections.
     *
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