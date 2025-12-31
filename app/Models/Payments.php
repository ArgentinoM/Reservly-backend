<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'stripe_id',
        'amount',
        'currency',
        'receipt_url',
        'status',
        'payment_method',
        'reservation_id',
        'user_id'
    ];

    protected $casts = [
        'raw' => 'array',
    ];

    public function reservation()
    {
        return $this->belongsTo(Services::class, 'reservation_id', 'id');
    }
}
