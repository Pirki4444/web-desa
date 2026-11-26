@extends('admin.layouts.app')
@section('title', 'Profil Desa')
@section('content')
<h1 class="text-3xl font-bold mb-6">Profil Desa</h1>
<form method="POST" action="{{ route('admin.profile.update') }}" class="bg-white rounded-xl p-6 space-y-5">@csrf @method('PUT')
    <div class="grid md:grid-cols-2 gap-4">
        @foreach(['village_name'=>'Nama desa','district'=>'Kecamatan','regency'=>'Kabupaten','province'=>'Provinsi','postal_code'=>'Kode pos','village_head_name'=>'Nama kepala desa','phone'=>'Telepon','email'=>'Email','address'=>'Alamat','website'=>'Website'] as $field=>$label)
            <label class="text-sm font-medium">{{ $label }}<input name="{{ $field }}" value="{{ old($field, $profile->$field) }}" class="mt-1 block w-full rounded-lg border-slate-300"></label>
        @endforeach
        @foreach(['history'=>'Sejarah','vision'=>'Visi','mission'=>'Misi','geography'=>'Kondisi geografis','village_head_message'=>'Sambutan kepala desa'] as $field=>$label)
            <label class="md:col-span-2 text-sm font-medium">{{ $label }}<textarea name="{{ $field }}" rows="4" class="mt-1 block w-full rounded-lg border-slate-300">{{ old($field, $profile->$field) }}</textarea></label>
        @endforeach
        @foreach(['total_population'=>'Jumlah penduduk','total_families'=>'Jumlah keluarga','total_area'=>'Luas wilayah (ha)','total_dusun'=>'Jumlah dusun'] as $field=>$label)
            <label class="text-sm font-medium">{{ $label }}<input type="number" min="0" step="any" name="{{ $field }}" value="{{ old($field, $profile->$field) }}" class="mt-1 block w-full rounded-lg border-slate-300"></label>
        @endforeach
    </div><button class="rounded-lg bg-emerald-700 text-white px-5 py-2">Simpan profil</button>
</form>
<section class="mt-8 bg-white rounded-xl p-6"><h2 class="font-bold text-xl mb-4">Perangkat desa</h2><div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="border-b text-left"><th class="p-3">Nama</th><th class="p-3">Jabatan</th><th class="p-3">NIP</th><th class="p-3"></th></tr></thead><tbody>@forelse($officials as $official)<tr class="border-b"><td class="p-3">{{ $official->name }}</td><td class="p-3">{{ $official->position }}</td><td class="p-3">{{ $official->nip }}</td><td class="p-3"><form method="POST" action="{{ route('admin.profile.official.destroy', $official) }}" onsubmit="return confirm('Hapus perangkat desa ini?')">@csrf @method('DELETE')<button class="text-red-700">Hapus</button></form></td></tr>@empty<tr><td colspan="4" class="p-4 text-center">Belum ada data perangkat.</td></tr>@endforelse</tbody></table></div>
<form method="POST" action="{{ route('admin.profile.official.store') }}" class="grid md:grid-cols-4 gap-3 mt-6">@csrf<input name="name" required placeholder="Nama" class="rounded-lg border-slate-300"><input name="position" required placeholder="Jabatan" class="rounded-lg border-slate-300"><input name="nip" placeholder="NIP" class="rounded-lg border-slate-300"><button class="rounded-lg bg-emerald-700 text-white px-4 py-2">Tambah perangkat</button></form></section>
@endsection
