@extends('layouts.app')

@section('title', 'Articles & Insights - Ted Choi | Software Engineering Blog')
@section('meta_description', 'Explore technical articles, engineering thoughts, and perspectives on software architecture, AI, and web development by Ted Choi.')
@section('canonical_url', url('/articles'))
@section('og_title', 'Articles & Insights - Ted Choi')
@section('og_description', 'Explore technical articles, engineering thoughts, and perspectives on software architecture, AI, and web development by Ted Choi.')

@section('contents')
    <div id="container">
        <div class="bg-white px-4 pb-20 sm:px-6 lg:px-8 lg:pb-28 mb-8">
            <div class="relative mx-auto max-w-lg divide-y-2 divide-gray-200 lg:max-w-7xl">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Articles</h1>
                    <div class="mt-3 sm:mt-4 lg:items-center">
                        <p class="text-xl text-gray-500">Thoughts, notes, and technical insights.</p>
                    </div>
                </div>
                <div class="mt-6 grid gap-16 pt-10 lg:grid-cols-2 lg:gap-x-5 lg:gap-y-12">
                    @foreach ($articles as $article)
                        <div>
                            <p class="text-sm text-gray-500">
                                <time datetime="{{ $article->created_at->toDateString() }}">{{ $article->created_at->format('F d, Y') }}</time>
                            </p>
                            <a href="{{ route('article.show', ['article' => $article->id]) }}" class="mt-2 block">
                                <p class="text-xl font-semibold text-gray-900">{{ Str::title($article->title) }}</p>
                                <p class="mt-3 text-base text-gray-500">
                                    {!! Str::words(strip_tags(Str::of($article->content)->markdown()), 80) !!}
                                </p>
                            </a>
                            <div class="mt-3">
                                <a href="{{ route('article.show', ['article' => $article->id]) }}" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Read full story</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10 py-6">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection

