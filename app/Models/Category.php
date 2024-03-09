<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'image'
    ];

    public function products():HasMany{
        return $this->hasMany(Product::class,'idCategory');
    }
    public function subcategories():HasMany{
        return $this->hasMany(Category::class,'parent_id');
    }
    public function parent(): BelongsTo{
        return $this->belongsTo(Category::class,'parent_id');
    }
}
