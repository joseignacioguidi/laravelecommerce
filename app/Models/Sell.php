<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sell extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'idUser',
        'date',
        'total',
        'status'
    ];

    function items():HasMany{
        return $this->hasMany(ProductSell::class,'idSell');
    }
    function user(): BelongsTo{
        return $this->belongsTo(User::class,'idUser');
    }
}
