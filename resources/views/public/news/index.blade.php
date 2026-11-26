@extends('layouts.public')

@section('title', 'Berita Desa')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-8"><p class="text-emerald-700 font-medium">Informasi terkini</p><h1 class="text-4xl font-bold text-gray-900 mt-2">Berita Desa</h1></div>
    <form method="GET" action="{{ route('news.index') }}" class="bg-white rounded-xl shadow-sm p-4 mb-8 flex flex-col sm:flex-row gap-3">
        <input name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="flex-1 rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600">
        <select name="category" class="rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>@endforeach</select>
        <button class="btn-primary text-white rounded-lg px-5 py-2">Cari</button>
    </form>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($news as $item)
            <article class="bg-white rounded-xl shadow-sm overflow-hidden card-hover"><img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-48 object-cover"><div class="p-5"><p class="text-sm text-emerald-700">{{ $item->category }} · {{ $item->published_at?->format('d M Y') }}</p><h2 class="text-xl font-bold mt-2"><a class="hover:text-emerald-700" href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a></h2><p class="text-gray-600 mt-3">{{ $item->excerpt }}</p><a href="{{ route('news.show', $item->slug) }}" class="inline-block mt-4 text-emerald-700 font-semibold">Baca selengkapnya →</a></div></article>
        @empty<div class="md:col-span-3 bg-white rounded-xl p-8 text-center text-gray-600">Belum ada berita yang sesuai.</div>@endforelse
    </div>
    <div class="mt-8">{{ $news->links() }}</div>
</section>
@endsection
