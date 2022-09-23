@extends('layouts.app')

@section('contents')
    <div id="container">

        <div class="bg-white px-4 pt-16 pb-20 sm:px-6 lg:px-8 lg:pt-24 lg:pb-28">
            <div class="relative mx-auto max-w-lg divide-y-2 divide-gray-200 lg:max-w-7xl">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Articles</h2>
                    <div class="mt-3 sm:mt-4 lg:items-center">
                        <p class="text-xl text-gray-500">This is what I think.</p>
                    </div>
                </div>
                <div class="mt-6 grid gap-16 pt-10 lg:grid-cols-2 lg:gap-x-5 lg:gap-y-12">
                    @foreach ($articles as $article)
                        <div>
                            <p class="text-sm text-gray-500">
                                <time datetime="2020-03-16">{{ $article->created_at->format('m/d, Y') }}</time>
                            </p>
                            <a href="{{ route('article.show', ['article_id' => $article->id]) }}" class="mt-2 block">
                                <p class="text-xl font-semibold text-gray-900">{{ Str::title($article->title) }}</p>
                                <p class="mt-3 text-base text-gray-500">{{ Str::limit($article->content, 300) }}</p>
                            </a>
                            <div class="mt-3">
                                <a href="{{ route('article.show', ['article_id' => $article->id]) }}" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Read full story</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection

