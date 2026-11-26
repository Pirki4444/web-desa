@extends('admin.layouts.app')
@section('title', 'Tambah Berita')
@section('content')<h1 class="text-3xl font-bold mb-6">Tambah Berita</h1><form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl p-6 space-y-5">@csrf @include('admin.news._form', ['news' => null])<div class="flex gap-3"><button class="rounded-lg bg-emerald-700 text-white px-5 py-2">Simpan</button><a href="{{ route('admin.news.index') }}" class="px-5 py-2">Batal</a></div></form>@endsection
