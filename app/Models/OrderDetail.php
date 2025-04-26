<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
      // Define which fields are mass assignable
      protected $guarded = ['id'];

      // Relationship: Each order detail belongs to an order
      public function order()
      {
          return $this->belongsTo(Order::class, 'order_id');
      }
  
      // Relationship: Each order detail belongs to a product (if applicable)
      public function product()
      {
          return $this->belongsTo(Product::class, 'productid');
      }
  
      // Optionally, you can define a method for getting the formatted subtotal
      public function getFormattedSubtotalAttribute()
      {
          return number_format($this->subtotal, 2) . ' BDT';
      }
}
