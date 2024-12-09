<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'featured_image',
        'content',
        'meta_description',
        'status',
        'published_at',
        'views_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views_count' => 'integer'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('published_at');
    }

    public function getReadTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200); // Aproximativ 200 cuvinte pe minut
        return $minutes;
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }
}