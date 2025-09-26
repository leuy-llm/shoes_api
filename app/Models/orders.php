<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    /** @use HasFactory<\Database\Factories\OrdersFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total',
        'tax',
        'shipping',
        'final_total',
        'status',
    ];
        // Order.php
   // Relationships
   public function items()
   {
       return $this->hasMany(OrderItem::class);
   }

   public function address()
   {
       return $this->hasOne(OrderAddress::class);
   }

   public function user()
   {
       return $this->belongsTo(User::class);
   }

}
