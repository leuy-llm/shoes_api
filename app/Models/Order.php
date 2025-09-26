<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total', 'tax', 'shipping', 'final_total', 'status'];

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
