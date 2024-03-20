<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLISHED = 1;

    protected $fillable = [
        'user_id',
        'comment',
        'rate',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute()
    {
        if($this->user) {
            return $this->user->name;
        }
        return "Unknown";
    }
}
