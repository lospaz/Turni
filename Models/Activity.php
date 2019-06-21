<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    public function local(){
        return $this->belongsTo(Local::class);
    }

    public function tasks(){
        return $this->hasManyThrough(Task::class, ActivityHasTasks::class);
    }

    public function templates(){
        return $this->hasManyThrough(Template::class, TemplateHasActivities::class);
    }
}
