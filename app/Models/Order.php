<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name', 
        'subtotal', 
        'tax_amount', 
        'discount_amount', 
        'total', 
        'status', 
        'payment_method', 
        'transaction_id'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
