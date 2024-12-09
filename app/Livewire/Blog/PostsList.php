<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class PostsList extends Component
{
    use WithPagination;

    public $categorySlug = null;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getPostsProperty()
    {
        return Post::query()
            ->with('category')
            ->published()
            ->when($this->categorySlug, function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', $this->categorySlug);
                });
            })
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->ordered()
            ->paginate(9);
    }

    public function render()
    {
        return view('livewire.blog.posts-list', [
            'posts' => $this->posts,
            'categories' => Category::withCount(['posts' => function($query) {
                $query->published();
            }])->orderBy('name')->get()
        ])->layout('components.layouts.blog', [
            'title' => 'Blog SportClubPro',
            'metaDescription' => 'Articole despre management sportiv și administrarea cluburilor sportive'
        ]);
    }
}