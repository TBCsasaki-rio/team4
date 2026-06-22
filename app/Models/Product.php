<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $primaryKey = 'id';

    public $timestamps = false;
    
    protected $fillable = ['name', 'price', 'category_id'];

    // 不要かも：現時点で使用箇所なし
    public function categories(){
        // belongTo: カテゴリーを親として指定し所有
        return $this->belongsTo(Category::class);
    }

    // メイン画像：商品一覧に使用するために定義している
    //              一覧表示の際にwithで同時に呼び出すことで
    //              無駄なクエリ(N+1問題)を防げます。
    public function mainImage(){
        // hasOne:一つのモデルを所有する
        return $this->hasOne(ProductImage::class, 'product_id', 'id')->where('is_main', 1);
    }

    // 全ての商品画像：商品詳細の際に使用予定
    public function productImages()
    {
        // hasMany：複数のモデルを所有する
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

}
