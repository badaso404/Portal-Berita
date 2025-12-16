<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results - {{ config('app.name', 'Laravel News') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-red-600">
                                PortalBerita
                            </a>
                        </div>
                    </div>
                     <div class="flex items-center space-x-4">
                         <form action="{{ route('news.search') }}" method="GET" class="relative">
                            <input type="text" name="title" value="{{ request('title') }}" placeholder="Search news..." class="w-64 pl-4 pr-10 py-2 border rounded-full text-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                            <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-500 hover:text-red-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold mb-6">Search Results</h1>
            
            @if(request('title'))
                <p class="mb-4 text-gray-600">Showing results for: <span class="font-semibold">"{{ request('title') }}"</span></p>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($articles as $article)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            @if($article->image)
                            <img src="{{ filter_var($article->image, FILTER_VALIDATE_URL) ? $article->image : asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full aspect-video object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">No Image</div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center text-xs text-gray-500 mb-2">
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full mr-2">{{ $article->category->name }}</span>
                                <span>{{ $article->published_at ? $article->published_at->format('M d, Y') : 'Draft' }}</span>
                            </div>
                            <h2 class="text-xl font-semibold mb-2 line-clamp-2">
                                <a href="{{ route('news.show', $article->slug) }}" class="hover:text-red-600">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                            <a href="{{ route('news.show', $article->slug) }}" class="inline-block text-red-600 hover:text-red-800 font-medium">Read more &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        No news found matching your criteria.
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $articles->withQueryString()->links() }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                 <p class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} PortalBerita. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
