@extends('layouts.public')

@section('title', $news->title)

@section('content')
<article class="max-w-4xl mx-auto px-4 py-12">
    <a href="{{ route('news.index') }}" class="text-emerald-700 font-medium">← Kembali ke berita</a>
    <p class="text-emerald-700 mt-8">{{ $news->category }} · {{ $news->published_at?->format('d M Y') }}</p>
    <h1 class="text-4xl font-bold text-gray-900 mt-2">{{ $news->title }}</h1>
    <p class="text-gray-500 mt-3">{{ $news->author?->name }} · {{ number_format($news->views) }} kali dibaca</p>
    <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full max-h-[28rem] object-cover rounded-2xl mt-8">
    <p class="text-xl text-gray-600 leading-8 mt-8">{{ $news->excerpt }}</p>
    <div class="prose prose-lg max-w-none mt-6">{!! $news->content !!}</div>
</article>
@if($relatedNews->isNotEmpty())<section class="max-w-7xl mx-auto px-4 pb-12"><h2 class="text-2xl font-bold mb-5">Berita terkait</h2><div class="grid md:grid-cols-3 gap-5">@foreach($relatedNews as $item)<a href="{{ route('news.show', $item->slug) }}" class="bg-white rounded-xl p-5 shadow-sm font-semibold hover:text-emerald-700">{{ $item->title }}</a>@endforeach</div></section>@endif
@endsection
