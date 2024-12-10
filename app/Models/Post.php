<?php

namespace App\Models;

use Illuminate\Support\Str;
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

    public function getFeaturedImageUrlAttribute()
{
    if (!$this->featured_image) {
        return null;
    }
    
    // Verificăm dacă featured_image începe cu 'storage/'
    if (Str::startsWith($this->featured_image, 'storage/')) {
        return url($this->featured_image);
    }

    // Dacă nu începe cu 'storage/', adăugăm prefixul
    return url('storage/' . $this->featured_image);
}
     /**
     * Get the SEO title for the post.
     */
    public function getSeoTitleAttribute(): string
    {
        return $this->title . ' - Blog SportClubPro';
    }

    /**
     * Get the SEO description for the post.
     */
    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        
        // Generăm o descriere din conținut dacă nu există meta_description
        return Str::limit(
            strip_tags($this->content),
            160,
            '...'
        );
    }

    /**
     * Get the Open Graph type.
     */
    public function getOgTypeAttribute(): string
    {
        return 'article';
    }

    /**
     * Get the article publish time for Open Graph.
     */
    public function getOgPublishTimeAttribute(): string
    {
        return $this->published_at->toIso8601String();
    }

    /**
     * Get the article modified time for Open Graph.
     */
    public function getOgModifiedTimeAttribute(): string
    {
        return $this->updated_at->toIso8601String();
    }

    /**
     * Get the Open Graph image URL.
     */
    public function getOgImageAttribute(): ?string
    {
        if ($this->featured_image) {
            return url($this->featured_image);
        }
        
        // Imagine default dacă nu există featured image
        return url('assets/OG-sportclubpro.jpg');
    }

}