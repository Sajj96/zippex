<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'blog_category_id',
        'description',
        'image_path'
    ];

    public const LIMIT = 40;

    public function limit()
    {
        return Str::words(strip_tags($this->description), self::LIMIT);
    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
