@extends('admin.layouts.app')
@section('title', 'Tambah Agenda')
@section('content')<h1 class="text-3xl font-bold mb-6">Tambah Agenda</h1><form method="POST" action="{{ route('admin.events.store') }}" class="bg-white rounded-xl p-6 space-y-5">@csrf @include('admin.events._form', ['event' => null])<button class="rounded-lg bg-emerald-700 text-white px-5 py-2">Simpan</button></form>@endsection
