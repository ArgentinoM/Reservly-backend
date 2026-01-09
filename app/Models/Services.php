<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'desc',
        'price',
        'duration',
        'img',
        'user_id',
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'service_id', 'id');
    }

    public function rating()
    {
        return $this->hasOne(ServiceRating::class, 'service_id', 'id');
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class, 'service_id', 'id');
    }
}
