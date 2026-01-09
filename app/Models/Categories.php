<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'category_services';

    protected $fillable = [
        'name',
        'desc'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function services()
    {
        return $this->hasMany(Services::class, 'category_id', 'id');
    }
}
