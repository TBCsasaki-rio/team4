<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'id';

    public $timestamps = false;

    // なぜかデータベースにtinyInt型(0 - 1)で登録されてしまっているので、
    // booleanに変換しています（原因：LaravelとMysqlの問題らしい)
    protected $casts =[
        'is_main' => 'boolean',
    ];
    
}
