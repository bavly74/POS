<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use App\User;
class Role extends LaratrustRole
{
    public $guarded = [];
    public function users() {
        return $this->belongsToMany(User::class);
    }
}
