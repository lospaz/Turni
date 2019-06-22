<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftHasUsers extends Model
{
    protected $fillable = ['shift_id', 'user_id'];

}
