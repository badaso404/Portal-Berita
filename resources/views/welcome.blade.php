<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel News') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased flex flex-col min-h-screen">
    
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 h-20 items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-3xl font-bold text-red-700 tracking-tighter hover:text-red-800 transition-colors">
                        PortalBerita<span class="text-gray-900">.</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-sm font-bold text-gray-900 hover:text-red-600 uppercase tracking-wide">Home</a>
                    @foreach($categories as $category)
                        <a href="{{ route('news.search', ['category' => $category->slug]) }}" class="text-sm font-bold text-gray-500 hover:text-red-600 uppercase tracking-wide">{{ $category->name }}</a>
                    @endforeach
                </div>

                <div class="flex items-center space-x-4">
                     <form action="{{ route('news.search') }}" method="GET" class="relative hidden lg:block">
                        <input type="text" name="title" placeholder="Search news..." class="w-48 pl-4 pr-10 py-2 border-b-2 border-gray-200 bg-transparent text-sm focus:outline-none focus:border-red-600 transition-colors">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-0 text-gray-400 hover:text-red-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                    
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold uppercase rounded hover:bg-red-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-900 text-gray-900 text-xs font-bold uppercase rounded hover:bg-gray-900 hover:text-white transition-colors">Log in</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Breaking News Ticker -->
    <div class="bg-red-600 text-white text-xs font-bold py-2 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
            <span class="sr-only">Breaking News:</span>
            <span class="bg-white text-red-600 px-2 py-0.5 rounded mr-3 uppercase tracking-wider">Breaking</span>
            <div class="truncate">
                @if($trending->isNotEmpty())
                    {{ $trending->first()->title }} - <span class="font-normal opacity-80">Read more about this story inside.</span>
                @else
                    Welcome to PortalBerita, your number one source for daily news.
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Hero Grid Section -->
        @if($featured)
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
            <!-- Main Featured Article (Occupies 2 columns) -->
            <div class="lg:col-span-2 group relative overflow-hidden rounded-lg shadow-lg h-[400px] md:h-[500px]">
                <a href="{{ route('news.show', $featured->slug) }}" class="block h-full">
                    @if($featured->image)
                        <img src="{{ filter_var($featured->image, FILTER_VALIDATE_URL) ? $featured->image : asset('storage/' . $featured->image) }}" alt="{{ $featured->title }}" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                    @else
                        <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-500">No Image</div>
                    @endif
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent p-6 md:p-10">
                        <span class="bg-red-600 text-white text-xs px-2 py-1 uppercase font-bold tracking-wider mb-2 inline-block">{{ $featured->category->name }}</span>
                        <h2 class="text-2xl md:text-4xl font-bold text-white leading-tight mb-2 group-hover:underline decoration-red-600 decoration-2 underline-offset-4">
                            {{ $featured->title }}
                        </h2>
                        <div class="text-gray-300 text-xs md:text-sm flex items-center mt-2">
                            <span class="font-semibold text-white mr-2">{{ $featured->user->name }}</span>
                            <span class="mr-2">&bull;</span>
                            <span>{{ $featured->published_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Side Featured Articles (Stacked) -->
            <div class="grid grid-cols-1 gap-6 h-[500px] hidden lg:grid">
                @foreach($articles->take(2) as $subFeatured)
                <div class="relative overflow-hidden rounded-lg shadow group h-full">
                     <a href="{{ route('news.show', $subFeatured->slug) }}" class="block h-full">
                        @if($subFeatured->image)
                            <img src="{{ filter_var($subFeatured->image, FILTER_VALIDATE_URL) ? $subFeatured->image : asset('storage/' . $subFeatured->image) }}" alt="{{ $subFeatured->title }}" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gray-200"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent p-6 flex flex-col justify-end">
                            <span class="text-red-400 text-xs font-bold uppercase mb-1">{{ $subFeatured->category->name }}</span>
                            <h3 class="text-lg font-bold text-white leading-snug group-hover:text-red-400 transition-colors">
                                {{ $subFeatured->title }}
                            </h3>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Latest News Column -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between border-b-2 border-gray-100 pb-3 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Latest News</h2>
                    <a href="{{ route('news.search') }}" class="text-sm font-bold text-red-600 hover:text-red-800 uppercase tracking-wide">See All</a>
                </div>

                <div class="space-y-8">
                    @foreach($articles->skip(2) as $article)
                    <article class="flex flex-col md:flex-row gap-6 group">
                        <a href="{{ route('news.show', $article->slug) }}" class="block w-full md:w-1/3 flex-shrink-0 h-48 md:h-40 overflow-hidden rounded-lg bg-gray-100">
                             @if($article->image)
                                <img src="{{ filter_var($article->image, FILTER_VALIDATE_URL) ? $article->image : asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                            @endif
                        </a>
                        <div class="flex-grow">
                            <div class="flex items-center text-xs text-gray-500 mb-2 uppercase tracking-wide font-bold">
                                <span class="text-red-600 mr-2">{{ $article->category->name }}</span>
                                <span>{{ $article->published_at->format('M d, Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                <a href="{{ route('news.show', $article->slug) }}" class="group-hover:text-red-600 transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-2">
                                {{ Str::limit(strip_tags($article->content), 150) }}
                            </p>
                        </div>
                    </article>
                    @endforeach
                </div>
                
                 <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-10">
                <!-- Trending / Editor's Pick -->
                <div>
                     <h3 class="text-lg font-bold text-gray-900 border-l-4 border-red-600 pl-3 mb-6">Trending Now</h3>
                     <div class="space-y-4">
                        @php $count = 1; @endphp
                        @foreach($trending as $trend)
                        <a href="{{ route('news.show', $trend->slug) }}" class="flex gap-4 group items-start">
                            <span class="text-3xl font-bold text-gray-200 group-hover:text-red-600 transition-colors leading-none -mt-1">{{ sprintf('%02d', $count++) }}</span>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 leading-snug group-hover:text-red-600 transition-colors mb-1">
                                    {{ $trend->title }}
                                </h4>
                                <span class="text-xs text-gray-500">{{ $trend->category->name }}</span>
                            </div>
                        </a>
                        @endforeach
                     </div>
                </div>

                <!-- Newsletter -->
                <div class="bg-gray-100 p-8 rounded-lg text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Subscribe</h3>
                    <p class="text-gray-600 text-sm mb-6">Get the latest updates directly to your inbox.</p>
                    <form class="space-y-3">
                        <input type="email" placeholder="Email address" class="w-full px-4 py-2 text-sm border-gray-300 rounded focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        <button class="w-full bg-red-600 text-white font-bold text-sm py-2 rounded hover:bg-red-700 transition-colors uppercase tracking-wide">Subscribe</button>
                    </form>
                </div>

                <!-- Ad Placeholder -->
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-400 text-sm font-bold tracking-widest uppercase rounded">
                    Advertisement
                </div>
            </aside>
        </div>
    </main>

    <!-- Professional Footer -->
    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <a href="{{ route('home') }}" class="text-3xl font-bold text-white tracking-tighter mb-6 inline-block">PortalBerita<span class="text-red-600">.</span></a>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                        Delivering the latest and most reliable news from around the world. We are committed to truth, accuracy, and integrity in journalism.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider mb-6 text-sm">Sections</h4>
                    <ul class="space-y-3 text-sm">
                         @foreach($categories->take(5) as $category)
                            <li><a href="{{ route('news.search', ['category' => $category->slug]) }}" class="hover:text-red-500 transition-colors">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                     <h4 class="text-white font-bold uppercase tracking-wider mb-6 text-sm">Company</h4>
                     <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-red-500 transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-red-500 transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-red-500 transition-colors">Privacy Policy</a></li>
                     </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 font-medium">
                <p>&copy; {{ date('Y') }} PortalBerita Inc. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white">Twitter</a>
                    <a href="#" class="hover:text-white">Facebook</a>
                    <a href="#" class="hover:text-white">Instagram</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
