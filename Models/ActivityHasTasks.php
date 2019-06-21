<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityHasTasks extends Model
{
    protected $fillable = ['activity_id', 'task_id'];
}
