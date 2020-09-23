<?php

namespace Oxygencms\Core\Models;

use DateTimeInterface;
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

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param \DateTimeInterface $date
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
