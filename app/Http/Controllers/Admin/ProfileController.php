<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use App\Models\VillageOfficial;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = VillageProfile::firstOrCreate(
            [],
            ['village_name' => 'Desa Maju Sejahtera']
        );

        $officials = VillageOfficial::orderBy('order', 'asc')->get();

        return view('admin.profile.edit', compact('profile', 'officials'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'village_name'       => 'required|string|max:255',
            'district'           => 'nullable|string|max:255',
            'regency'            => 'nullable|string|max:255',
            'province'           => 'nullable|string|max:255',
            'postal_code'        => 'nullable|string|max:10',
            'history'            => 'nullable|string',
            'vision'             => 'nullable|string',
            'mission'            => 'nullable|string',
            'geography'          => 'nullable|string',
            'village_head_name'  => 'nullable|string|max:255',
            'village_head_message' => 'nullable|string',
            'total_population'   => 'nullable|integer|min:0',
            'total_families'     => 'nullable|integer|min:0',
            'total_area'         => 'nullable|numeric|min:0',
            'total_dusun'        => 'nullable|integer|min:0',
            'phone'              => 'nullable|string|max:50',
            'email'              => 'nullable|email|max:255',
            'address'            => 'nullable|string|max:500',
            'website'            => 'nullable|url|max:255',
        ]);

        $profile = VillageProfile::firstOrCreate([]);
        $profile->update($request->except(['_token', '_method']));

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil desa berhasil diperbarui.');
    }

    // Officials CRUD
    public function storeOfficial(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'nip'      => 'nullable|string|max:50',
            'phone'    => 'nullable|string|max:20',
            'order'    => 'nullable|integer|min:0',
        ]);

        VillageOfficial::create([
            'name'      => $request->name,
            'position'  => $request->position,
            'nip'       => $request->nip,
            'phone'     => $request->phone,
            'order'     => $request->order ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    public function destroyOfficial(VillageOfficial $official)
    {
        $official->delete();
        return redirect()->route('admin.profile.edit')
            ->with('success', 'Perangkat desa berhasil dihapus.');
    }
}
