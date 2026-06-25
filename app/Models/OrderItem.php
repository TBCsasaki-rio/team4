<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
