<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_NEW = 0;
    public const STATUS_CHECKEDOUT = 1;
    public const STATUS_EXPIRED = 2;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductPriceAttribute()
    {
        if($this->product) {
            return $this->product->price;
        }
        return 0;
    }
}
