<?php

namespace Modules\Shift\Models;

use App\User;
use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shift extends Model {

    protected $fillable = ['template_id'];

    protected $dates = ['start', 'end'];

    public function template(){
        return $this->belongsTo(Template::class);
    }

    public function activities(){
        return $this->belongsToMany(Activity::class, 'shift_has_activities',
            'shift_id', 'activity_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'shift_has_users',
            'shift_id', 'user_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public static function boot() {
        parent::boot();
        static::creating(function($model){
           $model->created_by = Auth::id();
        });
    }

    public function getActivities(){
        if($this->template)
            return $this->template->activities;
        else
            return $this->activities;
    }
}
