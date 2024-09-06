<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BlogStatus;
use Kalnoy\Nestedset\NodeTrait;

class BlogCategory extends Model
{
    use HasFactory;


    protected $table = 'blog_category';
    protected $fillable = [
        'name',
        'status',
        'parent_id',
        'level',
    ];

    // Định nghĩa mối quan hệ với parent category
    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }
    public function getParentOptions()
    {
        return self::where('id', '!=', $this->id)->get();
    }

    public function getStatusLabelAttribute()
    {
        return BlogStatus::from($this->status)->label();
    }
    public function getStatusBadgeColorAttribute()
    {
        return BlogStatus::from($this->status)->badgeColor();
    }
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'pivot_blog_category',  'blog_id', 'category_id');
    }
}
