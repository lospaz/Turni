<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftHasActivities extends Model
{
    protected $fillable = ['shift_id', 'activity_id'];
}
