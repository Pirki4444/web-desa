<!doctype html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>@yield('title', 'Admin') · Admin Desa</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-100 text-slate-800 min-h-screen">
<header class="bg-emerald-900 text-white"><div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-4"><a href="{{ route('admin.dashboard') }}" class="font-bold text-lg">Admin Desa Maju Sejahtera</a><nav class="flex flex-wrap gap-4 text-sm"><a href="{{ route('admin.dashboard') }}">Dashboard</a><a href="{{ route('admin.profile.edit') }}">Profil</a><a href="{{ route('admin.news.index') }}">Berita</a><a href="{{ route('admin.events.index') }}">Agenda</a><a href="{{ route('admin.service-types.index') }}">Jenis Layanan</a><a href="{{ route('admin.service-requests.index') }}">Pengajuan</a></nav><form method="POST" action="{{ route('logout') }}">@csrf<button class="rounded bg-white/15 px-3 py-2 text-sm">Keluar</button></form></div></header>
<main class="max-w-7xl mx-auto px-4 py-8">
    @if(session('success'))<div class="mb-5 rounded-lg bg-emerald-100 text-emerald-900 px-4 py-3">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-5 rounded-lg bg-red-100 text-red-800 px-4 py-3">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="mb-5 rounded-lg bg-red-100 text-red-800 px-4 py-3"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @yield('content')
</main></body></html>
