<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {

    protected $fillable = ['name'];

    public function activities(){
        return $this->belongsToMany(Activity::class, 'template_has_activities',
            'template_id', 'activity_id');
    }

    public function shifts(){
        return $this->hasMany(Shift::class);
    }

}
