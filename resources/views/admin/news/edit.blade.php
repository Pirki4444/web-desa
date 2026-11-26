@extends('admin.layouts.app')
@section('title', 'Edit Berita')
@section('content')<h1 class="text-3xl font-bold mb-6">Edit Berita</h1><form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="bg-white rounded-xl p-6 space-y-5">@csrf @method('PUT') @include('admin.news._form', ['news' => $news])<div class="flex gap-3"><button class="rounded-lg bg-emerald-700 text-white px-5 py-2">Simpan perubahan</button><a href="{{ route('admin.news.index') }}" class="px-5 py-2">Batal</a></div></form>@endsection
