<?php
namespace Oxygencms\Core\Observers;

use Oxygencms\Core\Models\Temporary;

class TemporaryObserver
{

    /**
     * Handle the Observer "created" event.
     *
     * @return void
     */
    public function created()
    {
        if(Temporary::count() > config('oxygen.temporaries_count')) {
            Temporary::first()->delete();
        }
    }
}