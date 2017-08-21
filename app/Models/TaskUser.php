<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskUser extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }
}
