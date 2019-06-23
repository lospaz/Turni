<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $fillable = ['name', 'local_id'];

    public function local(){
        return $this->belongsTo(Local::class);
    }

    public function tasks(){
        return $this->belongsToMany(Task::class, 'activity_has_tasks',
            'activity_id', 'task_id');
    }

    public function templates(){
        return $this->belongsToMany(Template::class, 'template_has_activities',
            'activity_id', 'template_id');
    }

    public function getTasks(){
        return $this->tasks->map->only(['name', 'description'])->toJson();
    }
}
