@extends('layouts.public')

@section('title', 'Layanan Masyarakat')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-12">
    <p class="text-emerald-700 font-medium">Pelayanan warga</p><h1 class="text-4xl font-bold mt-2">Layanan Masyarakat</h1><p class="text-gray-600 mt-3 mb-8">Pilih layanan dan lengkapi formulir untuk mengajukan permohonan.</p>
    @if($serviceTypes->isNotEmpty())<div class="grid md:grid-cols-2 gap-5 mb-12">@foreach($serviceTypes as $type)<article class="bg-white rounded-xl shadow-sm p-6"><div class="flex justify-between gap-4"><h2 class="text-xl font-bold">{{ $type->name }}</h2><span class="text-xs text-emerald-800 bg-emerald-100 rounded-full px-3 py-1 h-fit">{{ $type->fee }}</span></div><p class="text-gray-600 mt-3">{{ $type->description }}</p><p class="text-sm text-gray-500 mt-3">Perkiraan waktu: {{ $type->estimated_time }}</p>@if($type->requirements)<h3 class="font-semibold mt-4">Persyaratan</h3><ul class="list-disc pl-5 text-sm text-gray-600 mt-2">@foreach($type->requirements as $requirement)<li>{{ $requirement }}</li>@endforeach</ul>@endif</article>@endforeach</div>@endif
    <div class="max-w-3xl bg-white rounded-2xl shadow-sm p-6 sm:p-8"><h2 class="text-2xl font-bold">Ajukan layanan</h2>
        @if($errors->any())<div class="bg-red-50 text-red-700 rounded-lg p-4 mt-5"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('services.submit') }}" class="grid sm:grid-cols-2 gap-4 mt-6">@csrf
            <label class="text-sm font-medium">Nama lengkap<input name="applicant_name" value="{{ old('applicant_name') }}" required class="block w-full rounded-lg border-gray-300 mt-1"></label>
            <label class="text-sm font-medium">NIK<input name="nik" value="{{ old('nik') }}" inputmode="numeric" maxlength="16" required class="block w-full rounded-lg border-gray-300 mt-1"></label>
            <label class="text-sm font-medium">Nomor HP/WhatsApp<input name="phone" value="{{ old('phone') }}" required class="block w-full rounded-lg border-gray-300 mt-1"></label>
            <label class="text-sm font-medium">Jenis layanan<select name="service_type_id" required class="block w-full rounded-lg border-gray-300 mt-1"><option value="">Pilih layanan</option>@foreach($serviceTypes as $type)<option value="{{ $type->id }}" @selected(old('service_type_id') == $type->id)>{{ $type->name }}</option>@endforeach</select></label>
            <label class="sm:col-span-2 text-sm font-medium">Keterangan<textarea name="description" rows="4" class="block w-full rounded-lg border-gray-300 mt-1">{{ old('description') }}</textarea></label>
            <button class="btn-primary sm:col-span-2 text-white rounded-lg px-5 py-3 font-semibold">Kirim pengajuan</button>
        </form>
    </div>
    <p class="mt-6 text-gray-600">Sudah mengajukan? <a class="text-emerald-700 font-semibold" href="{{ route('services.track') }}">Cek status pengajuan →</a></p>
</section>
@endsection
