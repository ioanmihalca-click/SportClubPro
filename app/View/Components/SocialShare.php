<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SocialShare extends Component
{
    public $url;
    public $title;
    public $description;

    public function __construct($url, $title, $description = '')
    {
        $this->url = urlencode($url);
        $this->title = urlencode($title);
        $this->description = urlencode($description);
    }

    public function render()
    {
        return view('components.social-share');
    }

    // Helper pentru URL-uri de sharing
    public function shareLinks(): array
    {
        return [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$this->url}",
            'twitter' => "https://twitter.com/intent/tweet?url={$this->url}&text={$this->title}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$this->url}",
            'whatsapp' => "https://wa.me/?text={$this->title}%20{$this->url}"
        ];
    }
}