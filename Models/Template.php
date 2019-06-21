<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {

    public function activities(){
        return $this->hasManyThrough(Activity::class, TemplateHasActivities::class);
    }

    public function shifts(){
        return $this->hasMany(Shift::class);
    }

}
