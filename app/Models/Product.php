<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'stock',
        'idCategory'
    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class, 'idCategory');
    }
    public function comments():HasMany
    {
        return $this->hasMany(Comment::class, 'idProduct');
    }
    public function productsImages():HasMany{
        return $this->hasMany(ProductImage::class,'idProduct');
    }
}
