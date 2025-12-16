<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - {{ config('app.name', 'Laravel News') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 font-sans antialiased flex flex-col min-h-screen">
    
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-red-600 tracking-tight">
                        PortalBerita
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-red-600 text-sm font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        <!-- Article Header -->
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <!-- Breadcrumb / Category -->
            <div class="mb-6 flex items-center space-x-2 text-sm text-gray-500 uppercase tracking-wider font-semibold">
                <span class="text-red-600">{{ $article->category->name }}</span>
                <span>/</span>
                <span>News</span>
            </div>

            <!-- Main Title -->
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                {{ $article->title }}
            </h1>

            <!-- Meta Data (Author & Date) -->
            <div class="flex items-center justify-between border-t border-b border-gray-100 py-4 mb-8">
                <div class="flex items-center space-x-4">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-lg">
                        {{ substr($article->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $article->user->name }}</p>
                        <p class="text-xs text-gray-500">Author</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-900">{{ $article->published_at->format('F d, Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $article->published_at->format('H:i') }} WIB</p>
                </div>
            </div>

            <!-- Share Buttons (Top) -->
            <div class="flex space-x-2 mb-8">
                <a href="#" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 flex items-center">
                    Share
                </a>
                <a href="#" class="px-4 py-2 bg-sky-500 text-white text-sm font-medium rounded hover:bg-sky-600 flex items-center">
                    Tweet
                </a>
                <a href="#" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded hover:bg-gray-900 flex items-center">
                    Copy Link
                </a>
            </div>

            <!-- Main Image -->
            @if($article->image)
            <figure class="mb-10">
                <img src="{{ filter_var($article->image, FILTER_VALIDATE_URL) ? $article->image : asset('storage/' . $article->image) }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-auto object-cover rounded-lg shadow-sm max-h-[600px]">
                <figcaption class="mt-2 text-center text-sm text-gray-500 italic">
                    {{ $article->title }} - Illustration
                </figcaption>
            </figure>
            @endif

            <!-- Article Body -->
            <div class="prose prose-lg max-w-none text-gray-800 leading-loose text-lg text-justify">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Tags (Mockup) -->
            <div class="mt-12 pt-6 border-t border-gray-200">
                <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase">Related Topics</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded-full hover:bg-gray-200 cursor-pointer">#{{ $article->category->name }}</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded-full hover:bg-gray-200 cursor-pointer">#News</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded-full hover:bg-gray-200 cursor-pointer">#Latest</span>
                </div>
            </div>
        </article>

        <!-- Related News Section -->
        @if($relatedNews->isNotEmpty())
        <div class="bg-gray-50 py-12 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 border-l-4 border-red-600 pl-3">Related News</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($relatedNews as $related)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <a href="{{ route('news.show', $related->slug) }}" class="block h-48 overflow-hidden">
                            @if($related->image)
                            <img src="{{ filter_var($related->image, FILTER_VALIDATE_URL) ? $related->image : asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                            @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                        </a>
                        <div class="p-4">
                            <span class="text-xs text-red-600 font-bold uppercase tracking-wider">{{ $related->category->name }}</span>
                            <h3 class="mt-2 text-lg font-bold text-gray-900 leading-snug line-clamp-2">
                                <a href="{{ route('news.show', $related->slug) }}" class="hover:text-red-600 transition-colors">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <p class="mt-2 text-xs text-gray-500">{{ $related->published_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </main>

    <!-- Professional Footer -->
    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-800 pb-8 mb-8">
                <div class="mb-4 md:mb-0">
                    <span class="text-2xl font-bold text-white">PortalBerita</span>
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="hover:text-white">About</a>
                    <a href="#" class="hover:text-white">Contact</a>
                    <a href="#" class="hover:text-white">Privacy</a>
                    <a href="#" class="hover:text-white">Terms</a>
                </div>
            </div>
            <div class="text-center md:text-left text-sm text-gray-500">
                &copy; {{ date('Y') }} PortalBerita. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
