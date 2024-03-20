<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'commission',
        'level_one',
        'level_two',
        'level_three'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
