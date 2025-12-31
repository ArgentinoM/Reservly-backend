<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRating extends Model
{
    protected $table = 'service_ratings';

    protected $fillable = [
        'service_id',
        'average_rating',
        'total_reviews'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function service()
    {
        return $this->hasOne(Services::class, 'service_id', 'id');
    }
}
