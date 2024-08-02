<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BlogStatus;

class BlogTag extends Model
{
    use HasFactory;

    protected $table = 'blog_tag';

    protected $fillable = [
        'name',
        'status',
        'description'
    ];

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
        return $this->belongsToMany(Blog::class, 'pivot_blog_tag', 'tag_id', 'blog_id');
    }
}
