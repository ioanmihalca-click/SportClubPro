<?php

namespace App\View\Components;

use App\Models\Post;
use Illuminate\View\Component;

class SchemaOrg extends Component
{
    public $post;
    public $schema;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->schema = $this->generateSchema();
    }

    protected function generateSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $this->post->title,
            'description' => $this->post->seo_description,
            'image' => $this->post->og_image,
            'datePublished' => $this->post->published_at->toIso8601String(),
            'dateModified' => $this->post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'SportClubPro',
                'url' => config('app.url')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'SportClubPro',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => url('images/logo.png')
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current()
            ],
            'articleSection' => $this->post->category->name ?? null,
            'wordCount' => str_word_count(strip_tags($this->post->content)),
            'articleBody' => strip_tags($this->post->content)
        ];
    }

    public function render()
    {
        return view('components.schema-org');
    }
}