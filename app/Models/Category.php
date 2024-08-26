<?php

namespace App\Models;

use App\Rules\filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['name', 'slug', 'parent_id', 'description', 'image', 'status'];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault([
                'name' => '-',
            ]);
    }
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=','active');
    }
    public function scopeStatus(Builder $builder,  $status)
    {
        $builder->where('status', '=', $status);
    }
    public function scopefilter(Builder $builder,  $filters)
    {
        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('categories.name', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                // "unique:categories,name,$id"
                Rule::unique('categories', 'name')->ignore($id),
              /*  function ($attribute, $value, $fail) {
                    if (strtolower($value) == 'laravel') {
                        $fail('This name is forbidden!');
                    }
                },*/
                'filter:php,laravel,html'
                // new filter(['laravel', 'php' , 'html', 'css']),
            ],
            'parent_id' => [
                'nullable', 'int', 'exists:categories,id'
            ],
            'image' => [
                'mimes:jpeg,png,jpg,gif,svg',
                'max:1048576',
                'dimensions:min_width=100,min_height=100'
            ],
            'status' => 'required|in:active,archived',
        ];
    }
}
