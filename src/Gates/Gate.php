<?php

namespace Oxygencms\Core\Gates;

use Illuminate\Support\Facades\Gate as GateFacade;

class Gate
{
    public function registerAuthGate()
    {
        GateFacade::define('access-backoffice', function ($user) {

            if ($user->superuser) {
                return true;
            }

            return false;
        });
    }
}