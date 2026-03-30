<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_name', 'total', 'status'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
