<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSell extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'idProduct',
        'idSell',
        'quantity',
        'individualPrice'
    ];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class,'idProduct');
    }
    public function sell():BelongsTo{
        return $this->belongsTo(Sell::class,'idSell');
    }
    
}
