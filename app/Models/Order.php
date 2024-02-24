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
    public const STATUS_CANCELLED = 2;

    protected $fillable = [
        'user_id',
        'code',
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

    public function products()
    {
        return $this->belongsToMany(Cart::class, 'order_items')
                    ->withPivot(['id', 'order_id', 'cart_id', 'amount']);
    }

    public function getUserNameAttribute()
    {
        if($this->user) {
            return $this->user->name;
        }
        return "Unknown";
    }

    public function getUserAddressAttribute()
    {
        if($this->address) {
            return $this->address->street.", ".$this->address->ward.", ".$this->address->district.", ".$this->region;
        }
        return "Unknown";
    }

    public function getUserPhoneAttribute()
    {
        if($this->user) {
            return $this->user->phone;
        }
        return "Unknown";
    }

    public function getTotalAmountAttribute()
    {
        $sum = 0;
        foreach($this->products as $product) {
            $sum += $product->pivot->amount;
        }
        return $sum;
    }
}
