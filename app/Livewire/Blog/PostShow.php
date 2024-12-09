<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Component;

class PostShow extends Component
{
    public Post $post;
    
    public function mount($slug)
    {
        $this->post = Post::where('slug', $slug)
            ->published()
            ->with(['category'])
            ->firstOrFail();
            
        // Incrementăm numărul de vizualizări
        $this->post->incrementViews();
    }

    public function render()
    {
        return view('livewire.blog.post-show', [
            'relatedPosts' => Post::published()
                ->where('category_id', $this->post->category_id)
                ->where('id', '!=', $this->post->id)
                ->ordered()
                ->limit(3)
                ->get()
        ])->layout('components.layouts.blog', [
            'seoTitle' => $this->post->seo_title,
            'seoDescription' => $this->post->seo_description,
            'ogType' => $this->post->og_type,
            'ogImage' => $this->post->og_image,
            'ogPublishTime' => $this->post->og_publish_time,
            'ogModifiedTime' => $this->post->og_modified_time,
        ]);
    }
}