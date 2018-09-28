<?php

namespace Oxygencms\Core\Models;

use Oxygencms\Core\Traits\CommonQueries;
use Oxygencms\Core\Traits\CommonAccessors;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use CommonAccessors, CommonQueries;
}
