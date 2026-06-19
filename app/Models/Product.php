<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $primaryKey = 'id';

    public $timestamps = false;
    
    protected $fillable = ['name', 'price', 'category_id'];

    public function categories(){
        // カテゴリーを親として設定
        return $this->belongsTo(Category::class);
    }

}
