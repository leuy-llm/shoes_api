<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    /** @use HasFactory<\Database\Factories\OrderAddressFactory> */
    use HasFactory;
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'zip_code',
        'card',
        'expiry',
        'cvv',
        'name_on_card',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
