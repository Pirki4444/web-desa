@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-emerald-700 to-emerald-600 text-white">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Selamat Datang di {{ $profile->village_name ?? 'Desa Maju Sejahtera' }}
            </h1>
            @if(isset($profile->village_head_message))
            <p class="text-lg text-emerald-100 mb-8 leading-relaxed">
                {{ Str::limit($profile->village_head_message, 200) }}
            </p>
            @endif
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('services.index') }}" class="bg-white text-emerald-700 px-8 py-3 rounded-lg font-semibold hover:bg-emerald-50 transition inline-flex items-center justify-center">
                    <i data-lucide="file-text" class="w-5 h-5 mr-2"></i>
                    Layanan Masyarakat
                </a>
                <a href="{{ route('services.track') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-emerald-700 transition inline-flex items-center justify-center">
                    <i data-lucide="search" class="w-5 h-5 mr-2"></i>
                    Cek Status Pengajuan
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Desa -->
<div class="container mx-auto px-4 -mt-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @if(isset($profile->total_population))
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <div class="bg-emerald-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="users" class="w-7 h-7 text-emerald-700"></i>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($profile->total_population) }}</div>
            <div class="text-sm text-gray-600 mt-1">Jumlah Penduduk</div>
        </div>
        @endif
        
        @if(isset($profile->total_families))
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <div class="bg-emerald-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="home" class="w-7 h-7 text-emerald-700"></i>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($profile->total_families) }}</div>
            <div class="text-sm text-gray-600 mt-1">Kepala Keluarga</div>
        </div>
        @endif
        
        @if(isset($profile->total_area))
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <div class="bg-emerald-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="map" class="w-7 h-7 text-emerald-700"></i>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($profile->total_area, 1) }}</div>
            <div class="text-sm text-gray-600 mt-1">Luas Wilayah (km²)</div>
        </div>
        @endif
        
        @if(isset($profile->total_dusun))
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <div class="bg-emerald-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="landmark" class="w-7 h-7 text-emerald-700"></i>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $profile->total_dusun }}</div>
            <div class="text-sm text-gray-600 mt-1">Jumlah Dusun</div>
        </div>
        @endif
    </div>
</div>

<!-- Berita Desa Terbaru -->
<div class="container mx-auto px-4 py-16">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Berita Desa Terbaru</h2>
            <p class="text-gray-600 mt-1">Informasi dan update terkini dari desa</p>
        </div>
        <a href="{{ route('news.index') }}" class="text-emerald-700 font-semibold hover:text-emerald-800 inline-flex items-center">
            Lihat Semua
            <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
        </a>
    </div>
    
    @if($latestNews->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($latestNews as $news)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
            <div class="h-48 bg-gray-200 overflow-hidden">
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            </div>
            <div class="p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $news->category }}
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ $news->published_at->format('d M Y') }}
                    </span>
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2">{{ $news->title }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $news->excerpt }}</p>
                <a href="{{ route('news.show', $news->slug) }}" class="text-emerald-700 font-semibold text-sm hover:text-emerald-800 inline-flex items-center">
                    Baca Selengkapnya
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center text-gray-500 py-12">
        <i data-lucide="newspaper" class="w-16 h-16 mx-auto mb-4 opacity-50"></i>
        <p>Belum ada berita tersedia</p>
    </div>
    @endif
</div>

<!-- Agenda Kegiatan -->
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Agenda Kegiatan</h2>
                <p class="text-gray-600 mt-1">Jadwal kegiatan dan acara desa</p>
            </div>
            <a href="{{ route('events.index') }}" class="text-emerald-700 font-semibold hover:text-emerald-800 inline-flex items-center">
                Lihat Semua
                <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
        
        @if($upcomingEvents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($upcomingEvents as $event)
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-start gap-4">
                    <div class="bg-emerald-700 text-white rounded-lg p-3 text-center flex-shrink-0">
                        <div class="text-2xl font-bold">{{ $event->start_datetime->format('d') }}</div>
                        <div class="text-xs uppercase">{{ $event->start_datetime->format('M') }}</div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="mb-2">
                            <span class="bg-{{ $event->status_color }}-100 text-{{ $event->status_color }}-700 text-xs font-semibold px-2 py-1 rounded">
                                {{ $event->status_label }}
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $event->title }}</h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p class="flex items-center">
                                <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                                {{ $event->start_datetime->format('H:i') }} WIB
                            </p>
                            <p class="flex items-center">
                                <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                                {{ $event->location }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-gray-500 py-12 bg-white rounded-lg">
            <i data-lucide="calendar" class="w-16 h-16 mx-auto mb-4 opacity-50"></i>
            <p>Belum ada agenda kegiatan tersedia</p>
        </div>
        @endif
    </div>
</div>

<!-- Layanan Cepat -->
<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Layanan Masyarakat</h2>
        <p class="text-gray-600 mb-8">Ajukan permohonan surat dan layanan administrasi desa secara online</p>
        
        <div class="bg-emerald-50 border-2 border-emerald-200 rounded-lg p-8">
            <i data-lucide="file-check" class="w-16 h-16 mx-auto text-emerald-700 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Layanan Administrasi Online</h3>
            <p class="text-gray-700 mb-6">
                Ajukan permohonan surat keterangan domisili, SKTM, surat usaha, dan layanan lainnya tanpa harus datang ke kantor desa.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('services.index') }}" class="bg-emerald-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-800 transition inline-flex items-center justify-center">
                    <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                    Ajukan Layanan
                </a>
                <a href="{{ route('services.track') }}" class="bg-white text-emerald-700 border-2 border-emerald-700 px-6 py-3 rounded-lg font-semibold hover:bg-emerald-50 transition inline-flex items-center justify-center">
                    <i data-lucide="search" class="w-5 h-5 mr-2"></i>
                    Cek Status Pengajuan
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection
