@extends('layouts.public')

@section('title', 'Agenda Kegiatan')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-12">
    <p class="text-emerald-700 font-medium">Catat tanggalnya</p><h1 class="text-4xl font-bold text-gray-900 mt-2 mb-8">Agenda Kegiatan Desa</h1>
    <h2 class="text-2xl font-bold mb-4">Agenda mendatang</h2>
    <div class="grid md:grid-cols-2 gap-5 mb-12">
        @forelse($upcomingEvents as $event)<article class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-600"><p class="text-emerald-700 font-semibold">{{ $event->start_datetime?->format('l, d M Y · H:i') }}</p><h3 class="text-xl font-bold mt-2">{{ $event->title }}</h3><p class="text-gray-600 mt-3">{{ $event->description }}</p><p class="text-sm text-gray-500 mt-4">{{ $event->location }} · {{ $event->status_label }}</p></article>
        @empty<p class="text-gray-600">Belum ada agenda mendatang.</p>@endforelse
    </div>
    <h2 class="text-2xl font-bold mb-4">Kegiatan yang telah berlangsung</h2>
    <div class="space-y-3">@forelse($completedEvents as $event)<article class="bg-white rounded-xl p-5 shadow-sm flex flex-col sm:flex-row sm:justify-between gap-2"><div><h3 class="font-semibold">{{ $event->title }}</h3><p class="text-sm text-gray-600">{{ $event->location }}</p></div><time class="text-sm text-gray-500">{{ $event->start_datetime?->format('d M Y') }}</time></article>@empty<p class="text-gray-600">Belum ada kegiatan terdahulu.</p>@endforelse</div>
</section>
@endsection
