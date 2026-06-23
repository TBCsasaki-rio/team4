<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';

    public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'quantity' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'integer',
    ];
}
