<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $connection = 'mysql';
    Protected $table = 'stores';
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['name', 'slug', 'logo_image', 'description', 'cover_image', 'status'];

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }
}
