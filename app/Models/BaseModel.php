<?php

namespace Spa\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
