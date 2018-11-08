<?php

namespace Oxygencms\Core\Models;

use Oxygencms\Core\Traits\CommonQueries;
use Oxygencms\Core\Traits\CommonAccessors;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use CommonAccessors, CommonQueries, LogsActivity;

    /**
     * Logged attributes.
     *
     * @var bool $logUnguarded
     */
    protected static $logUnguarded = true;
    protected static $logFillable = true;
}
