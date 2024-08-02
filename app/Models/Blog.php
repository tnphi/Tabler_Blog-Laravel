<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';
    protected $fillable = [
        'title',
        'content',
        'isFeatured',
        'short_description',
        'featured_image',
        'status',
    ];


    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'pivot_blog_category', 'blog_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'pivot_blog_tag', 'blog_id', 'tag_id');
    }
    
}
