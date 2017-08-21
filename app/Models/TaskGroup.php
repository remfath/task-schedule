<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskGroup extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'group_id');
    }
}
