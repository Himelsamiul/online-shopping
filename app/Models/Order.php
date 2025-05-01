<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    // Relationship: An order can have many order details
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // You might also want to have an accessor for calculating the total amount after discount
    public function getTotalAfterDiscountAttribute()
    {
        $total = $this->orderDetails->sum('subtotal');
        $discount = $this->discount; // Assuming you have a `discount` field in the orders table
        return $total - $discount;
    }

    // You can also define relationships to other models, like Customer, if necessary
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
