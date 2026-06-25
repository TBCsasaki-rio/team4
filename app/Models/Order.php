<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
