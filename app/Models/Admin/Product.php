<?php

namespace App\Models\Admin;

use App\Http\Resources\Admin\CategoryResource;
use App\Models\Front\CardItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;
    public $translatedAttributes = ['des', 'name' , 'meta_des' , 'meta_title' , 'slug'];
    protected $fillable = ['category_id' , 'price' , 'star' , 'discount' , 'old_price'];
    public $translationForeignKey = 'product_id';
    public $translationModel = 'App\Models\Admin\ProductTranslation';

    public function gallery(){
        return $this->hasMany(Gallary::class , 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function cardItems()
    {
        return $this->hasMany(CardItem::class);
    }
}
