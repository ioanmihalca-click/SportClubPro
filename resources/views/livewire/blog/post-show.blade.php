
<article class="max-w-4xl mx-auto">
    <!-- Breadcrumbs -->
    <div class="mb-6 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('blog.index') }}" class="hover:text-teal-600 dark:hover:text-teal-400">Blog</a>
        <span class="mx-2">/</span>
        <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-teal-600 dark:hover:text-teal-400">
            {{ $post->category->name }}
        </a>
    </div>

    <!-- Article Header -->
    <header class="mb-8">
        <h1 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">
            {{ $post->title }}
        </h1>
        
        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
            <span>
                {{ $post->published_at->format('d M Y') }}
            </span>
            <span>&bull;</span>
            <span>
                {{ $post->read_time }} min citire
            </span>
            <span>&bull;</span>
            <span>
                {{ $post->views_count }} vizualizări
            </span>
        </div>
    </header>

    <!-- Featured Image -->
    @if($post->featured_image)
        <div class="mb-8">
            <img 
                src="{{ $post->featured_image }}" 
                alt="{{ $post->title }}" 
                class="w-full rounded-lg shadow-lg"
            >
        </div>
    @endif

    <!-- Article Content -->
    <div class="mb-12 prose prose-lg dark:prose-invert max-w-none">
        {!! $post->content !!}
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->isNotEmpty())
        <div class="pt-8 mt-8 border-t border-gray-200 dark:border-gray-700">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">
                Articole similare
            </h2>
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach($relatedPosts as $relatedPost)
                    <article class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                        @if($relatedPost->featured_image)
                            <img 
                                src="{{ $relatedPost->featured_image }}" 
                                alt="{{ $relatedPost->title }}" 
                                class="object-cover w-full h-48"
                            >
                        @endif
                        <div class="p-6">
                            <h3 class="mb-2 text-lg font-semibold">
                                <a 
                                    href="/blog/{{ $relatedPost->slug }}" 
                                    class="text-gray-900 dark:text-white hover:text-teal-600 dark:hover:text-teal-400"
                                >
                                    {{ $relatedPost->title }}
                                </a>
                            </h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $relatedPost->published_at->format('d M Y') }}
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
</article>