@extends('admin.layouts.app')
@section('title', 'Tambah Jenis Layanan')
@section('content')<h1 class="text-3xl font-bold mb-6">Tambah Jenis Layanan</h1><form method="POST" action="{{ route('admin.service-types.store') }}" class="bg-white rounded-xl p-6 space-y-5">@csrf @include('admin.service_types._form', ['serviceType' => null, 'requirementsText' => ''])<button class="rounded-lg bg-emerald-700 text-white px-5 py-2">Simpan</button></form>@endsection
