@extends('admin.layouts.app')
@section('title', 'Edit Agenda')
@section('content')<h1 class="text-3xl font-bold mb-6">Edit Agenda</h1><form method="POST" action="{{ route('admin.events.update', $event) }}" class="bg-white rounded-xl p-6 space-y-5">@csrf @method('PUT') @include('admin.events._form', ['event' => $event])<button class="rounded-lg bg-emerald-700 text-white px-5 py-2">Simpan perubahan</button></form>@endsection
