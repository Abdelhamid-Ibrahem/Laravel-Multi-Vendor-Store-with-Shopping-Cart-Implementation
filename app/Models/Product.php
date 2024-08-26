<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tag;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['store_id ', 'name', 'slug', 'category_id', 'description', 'image', 'status', 'price', 'rating', 'compare_price'];

    public static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,           // Related Model
            'product_tag',         // Pivot table name
            'product_id',   // FK in pivot table for the current model
            'tag_id',       // FK in pivot table for the related model
            'id',              // PK current model
            'id'               // PK related model
        );
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://odoo-community.org/web/image/product.product/19823/image_1024/Default%20Product%20Images?unique=d6ed958';
        }
        if (Str::startsWith($this->image, ['http', 'https'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price){
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price), 0);
    }


}
