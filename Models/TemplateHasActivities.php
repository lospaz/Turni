<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateHasActivities extends Model
{
    protected $fillable = ['template_id', 'activity_id'];
}
