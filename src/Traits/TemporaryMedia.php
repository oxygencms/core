<?php

namespace Oxygencms\Core\Traits;

use Oxygencms\Core\Models\Model;
use Oxygencms\Core\Models\Temporary;

trait TemporaryMedia
{
    /**
     * Move the media from the temporary models to the created model and delete the temporary model
     *
     * @param Model $entity
     * @param int $temporary_id
     */
    public function moveMedia(Model $entity, int $temporary_id)
    {
        $temporary = Temporary::find($temporary_id);

        $media = $temporary->getMedia();

        $media->each(function ($item) use($entity) {
            $item->move($entity);
        });

        $temporary->delete();
    }

    /**
     * Create an instance of Temporary
     *
     * @return mixed
     */
    public function createTemporary()
    {
        return Temporary::create();
    }
}