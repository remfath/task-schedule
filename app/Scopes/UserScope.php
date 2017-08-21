<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserScope implements Scopre {
    public function apply(Builder $builder, Model $model) {
        return $builder->where('id', Auth::id);
    }
}
