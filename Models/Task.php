<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    protected $fillable = ['name', 'description'];

    public function activities(){
        return $this->hasManyThrough(Activity::class, ActivityHasTasks::class);
    }

}
