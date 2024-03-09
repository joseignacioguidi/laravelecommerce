<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'idUser',
        'idProduct',
        'valoration',
        'message'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class,'idUser');
    }
    public function product(): BelongsTo{
        return $this->belongsTo(Product::class,'idProduct');
    }
}
