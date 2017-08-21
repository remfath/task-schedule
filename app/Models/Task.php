<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\UserScope;

class Task extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function mails()
    {
        return $this->hasOne(TaskMail::class, 'task_id');
    }

    public function phones()
    {
        return $this->hasOne(TaskPhone::class, 'task_id');
    }

    public function logs()
    {
        return $this->hasMany(TaskLog::class, 'task_id');
    }

    public function server()
    {
        return $this->belongsTo(TaskServer::class);
    }

    public function user()
    {
        return $this->belongsTo(TaskUser::class);
    }

    public function group()
    {
        return $this->belongsTo(TaskGroup::class);
    }

    // public function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope(new UserScope);
    // }

}
