<!-- resources/views/livewire/blog/posts-list.blade.php -->
<div class="space-y-6">
    <!-- Search and Categories -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        <!-- Categories Sidebar -->
        <div class="space-y-4">
            <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Categorii</h2>
                <nav class="space-y-2">
                    <a href="/blog" 
                       class="block px-3 py-2 rounded-md {{ !$categorySlug ? 'bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-100' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Toate articolele
                    </a>
                    @foreach($categories as $category)
                        <a href="/blog/category/{{ $category->slug }}" 
                           class="block px-3 py-2 rounded-md {{ $categorySlug === $category->slug ? 'bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-100' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            {{ $category->name }} ({{ $category->posts_count }})
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="space-y-6 md:col-span-3">
            <!-- Search -->
            <div class="relative">
                <input 
                    wire:model.live="search"
                    type="text"
                    placeholder="Caută articole..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
            </div>

            @if($posts->isEmpty())
                <div class="py-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Nu am găsit articole care să corespundă criteriilor tale.</p>
                </div>
            @else
                <!-- Articles Grid -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($posts as $post)
                        <article class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                            @if($post->featured_image)
                                 <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="object-cover w-full h-auto">
                            @endif
                            <div class="p-6">
                                <span class="text-sm text-teal-600 dark:text-teal-400">{{ $post->category->name }}</span>
                                <h3 class="mt-2 text-xl font-semibold">
                                    <a href="/blog/{{ $post->slug }}" class="text-gray-900 line-clamp-2 dark:text-white hover:text-teal-600 dark:hover:text-teal-400">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="mt-2 text-gray-600 dark:text-gray-300 line-clamp-3">
                                    {{ $post->meta_description }}
                                </p>
                                <div class="flex items-center mt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span>{{ $post->published_at->format('d M Y') }}</span>
                                    <span class="mx-2">&bull;</span>
                                    <span>{{ $post->read_time }} min citire</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>