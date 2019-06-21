<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model {

    protected $fillable = ['name'];

    public function activities(){
        return $this->hasMany(Activity::class);
    }

}
