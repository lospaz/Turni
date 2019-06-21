<?php

namespace Modules\Shift\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model {

    public function template(){
        return $this->belongsTo(Template::class);
    }

    public function activities(){
        return $this->hasManyThrough(Activity::class, ShiftHasActivities::class);
    }

    public function users(){
        return $this->hasManyThrough(User::class, ShiftHasUsers::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
