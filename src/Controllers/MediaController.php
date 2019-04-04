<?php

namespace Oxygencms\Core\Controllers;

use Exception;
use Illuminate\Http\Request;
use Oxygencms\Core\Models\Temporary;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    /**
     * Get a list of the media for a given mediable.
     * Used in TinyMCE editor to list the media.
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function mediaList(Request $request)
    {
        $this->validate($request, [
            'mediable_type' => 'required|string',
            'mediable_id' => 'required|numeric',
        ]);

        $mediable = $request->mediable_type::findOrFail($request->mediable_id);

        $media_list = [];

        foreach ($mediable->media as $media) {
            array_push($media_list, [
                'title' => $media->name,
                'value' => $media->getFullUrl(),
            ]);

            if ($media->hasCustomProperty('generated_conversions')) {
                foreach ($media->getCustomProperty('generated_conversions') as $conversion => $status) {
                    if ($status) {
                        array_push($media_list, [
                            'title' => $media->name . '-' . $conversion,
                            'value' => $media->getFullUrl($conversion),
                        ]);
                    }
                }
            }
        };

        return $media_list;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file',
            'mediable_type' => 'required|string',
            'mediable_id' => 'required|numeric',
        ]);

        $mediable = $request->mediable_type::findOrFail($request->mediable_id);

        $media = $mediable->addMedia($request->file)->toMediaCollection();

        $media->url = $media->getFullUrl();

        return compact('media');
    }

    /**
     * @param Media   $media
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Media $media, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'collection_name' => 'required|string',
        ]);

        $this->checkAcceptableTypes($media, $request);

        $media->update($request->only('name', 'collection_name'));

        if (in_array($request->collection_name, ['image', 'images'])) {
            Artisan::call('medialibrary:regenerate', ['--ids' => $media->id, '--force' => true]);
        }

        return compact('media');
    }

    /**
     * @param Media $media
     * @throws Exception
     */
    public function destroy(Media $media)
    {
        $media->delete();
    }

    /**
     * Create a temporary model
     *
     * @return mixed
     */
    public function createTemporary()
    {
        $temporary = Temporary::create();

        session(['temporary-id-for-user-' . auth()->id() => $temporary->id]);

        return $temporary;
    }

    /**
     * @param Media   $media
     * @param Request $request
     * @throws Exception
     */
    private function checkAcceptableTypes(Media $media, Request $request)
    {
        if ($request->collection_name == 'image' && ! in_array($media->mime_type, config('oxygen.image_types'))) {
            throw new Exception("Can not assign $media->mime_type to the image collection.");
        }

        if ($request->collection_name == 'images' && ! in_array($media->mime_type, config('oxygen.image_types'))) {
            throw new Exception("Can not assign $media->mime_type to the images collection.");
        }

        if ($request->collection_name == 'videos' && ! in_array($media->mime_type, config('oxygen.video_types'))) {
            throw new Exception("Can not assign $media->mime_type to the videos collection.");
        }
    }
}
