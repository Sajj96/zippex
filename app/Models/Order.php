<?php

namespace App\Models;

use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, GenerateCode;

    public const STATUS_PENDING = 0;
    public const STATUS_CONFIRMED = 1;

    protected $fillable = [
        'user_id',
        'user_address_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
