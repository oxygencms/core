<?php

namespace Oxygencms\Core\Traits;

trait MediaMethods
{
    /**
     * Get the image from the single file collection called image.
     *
     * @param string $conversion
     * @return string
     */
    public function image(string $conversion = 'xs'): string
    {
        $media = $this->getFirstMedia('image');

        return $media ? $media->getUrl($conversion) : $this->placeholder();
    }

    /**
     * Get the first media from the images collection.
     *
     * @param string $conversion
     * @return string
     */
    public function firstImage(string $conversion = 'md'): string
    {
        $media = $this->getFirstMedia('images');

        return $media ? $media->getUrl($conversion) : $this->placeholder();
    }

    /**
     * @return string
     */
    public function placeholder(): string
    {
        return asset('images/placeholder.png');
    }
}
