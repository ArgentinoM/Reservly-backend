<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    public function user()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
