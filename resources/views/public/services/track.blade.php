@extends('layouts.public')

@section('title', 'Cek Status Pengajuan')

@section('content')
<section class="max-w-3xl mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-9"><p class="text-emerald-700 font-medium">Pelacakan layanan</p><h1 class="text-3xl font-bold mt-2">Cek Status Pengajuan</h1><p class="text-gray-600 mt-3">Masukkan kode tracking yang diterima setelah mengajukan layanan.</p>
        <form method="GET" action="{{ route('services.track') }}" class="flex flex-col sm:flex-row gap-3 mt-6"><input name="tracking_code" value="{{ request('tracking_code') }}" required placeholder="Contoh: DS-2026-0023" class="flex-1 uppercase rounded-lg border-gray-300"><button class="btn-primary text-white rounded-lg px-5 py-3">Cari status</button></form>
        @if($error)<div class="bg-red-50 text-red-700 rounded-lg p-4 mt-5">{{ $error }}</div>@endif
        @if($result)<article class="border border-gray-200 rounded-xl p-5 mt-6"><div class="flex flex-col sm:flex-row sm:justify-between gap-2"><div><p class="text-sm text-gray-500">Kode tracking</p><p class="font-bold text-lg">{{ $result->tracking_code }}</p></div><span class="rounded-full bg-emerald-100 text-emerald-800 px-3 py-1 h-fit">{{ ucfirst($result->status) }}</span></div><dl class="grid sm:grid-cols-2 gap-4 mt-5 text-sm"><div><dt class="text-gray-500">Pemohon</dt><dd class="font-medium">{{ $result->applicant_name }}</dd></div><div><dt class="text-gray-500">Jenis layanan</dt><dd class="font-medium">{{ $result->serviceType?->name }}</dd></div><div><dt class="text-gray-500">Tanggal pengajuan</dt><dd class="font-medium">{{ $result->created_at?->format('d M Y H:i') }}</dd></div>@if($result->admin_note)<div class="sm:col-span-2"><dt class="text-gray-500">Catatan petugas</dt><dd class="font-medium">{{ $result->admin_note }}</dd></div>@endif</dl></article>@endif
    </div>
</section>
@endsection
