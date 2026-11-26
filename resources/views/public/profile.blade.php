@extends('layouts.public')

@section('title', 'Profil Desa')

@section('content')
<section class="bg-emerald-800 text-white py-14">
    <div class="max-w-5xl mx-auto px-4">
        <p class="text-emerald-200">Mengenal desa kita</p>
        <h1 class="text-4xl font-bold mt-2">{{ $profile?->village_name ?? 'Desa Maju Sejahtera' }}</h1>
        <p class="mt-3 text-emerald-100">{{ $profile?->district }}, {{ $profile?->regency }}, {{ $profile?->province }}</p>
    </div>
</section>
<section class="max-w-5xl mx-auto px-4 py-12 space-y-10">
    @if($profile)
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([['Penduduk', number_format($profile->total_population)], ['Kepala Keluarga', number_format($profile->total_families)], ['Luas Wilayah', number_format((float) $profile->total_area, 2).' ha']] as [$label, $value])
                <div class="bg-white rounded-xl shadow-sm p-6"><p class="text-gray-500">{{ $label }}</p><p class="text-2xl font-bold text-emerald-800 mt-2">{{ $value }}</p></div>
            @endforeach
        </div>
        @foreach([['Sejarah Desa', $profile->history], ['Visi', $profile->vision], ['Misi', $profile->mission], ['Kondisi Geografis', $profile->geography]] as [$heading, $body])
            @if($body)<article class="bg-white rounded-xl shadow-sm p-6"><h2 class="text-2xl font-bold text-emerald-800 mb-3">{{ $heading }}</h2><p class="text-gray-700 leading-7 whitespace-pre-line">{{ $body }}</p></article>@endif
        @endforeach
        @if($profile->village_head_message)<article class="bg-emerald-50 rounded-xl p-6"><h2 class="text-2xl font-bold text-emerald-800 mb-3">Sambutan Kepala Desa</h2><p class="leading-7">{{ $profile->village_head_message }}</p><p class="font-semibold mt-4">{{ $profile->village_head_name }}</p></article>@endif
    @endif
    <div><h2 class="text-2xl font-bold text-emerald-800 mb-5">Perangkat Desa</h2><div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($officials as $official)<article class="bg-white rounded-xl shadow-sm p-5"><h3 class="font-semibold text-lg">{{ $official->name }}</h3><p class="text-emerald-700">{{ $official->position }}</p>@if($official->description)<p class="text-gray-600 mt-2">{{ $official->description }}</p>@endif</article>
        @empty<p class="text-gray-600">Informasi perangkat desa belum tersedia.</p>@endforelse
    </div></div>
</section>
@endsection
