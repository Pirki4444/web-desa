<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::orderBy('order', 'asc')->paginate(15);
        return view('admin.service_types.index', compact('serviceTypes'));
    }

    public function create()
    {
        return view('admin.service_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'required|string|max:20|unique:service_types,code',
            'description'    => 'nullable|string',
            'requirements'   => 'nullable|string',
            'estimated_time' => 'nullable|string|max:100',
            'fee'            => 'nullable|string|max:100',
            'order'          => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
        ], [
            'name.required' => 'Nama layanan wajib diisi.',
            'code.required' => 'Kode layanan wajib diisi.',
            'code.unique'   => 'Kode layanan sudah digunakan.',
        ]);

        // Parse requirements from textarea (one per line)
        $requirementsText = $request->requirements;
        $requirements = [];
        if (!empty($requirementsText)) {
            $requirements = array_filter(array_map('trim', explode("\n", $requirementsText)));
            $requirements = array_values($requirements);
        }

        ServiceType::create([
            'name'           => $request->name,
            'code'           => strtoupper($request->code),
            'description'    => $request->description,
            'requirements'   => $requirements,
            'estimated_time' => $request->estimated_time,
            'fee'            => $request->fee,
            'order'          => $request->order ?? 0,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.service-types.index')
            ->with('success', 'Jenis layanan berhasil ditambahkan.');
    }

    public function edit(ServiceType $serviceType)
    {
        $requirementsText = '';
        if ($serviceType->requirements) {
            $requirementsText = implode("\n", $serviceType->requirements);
        }
        return view('admin.service_types.edit', compact('serviceType', 'requirementsText'));
    }

    public function update(Request $request, ServiceType $serviceType)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'required|string|max:20|unique:service_types,code,' . $serviceType->id,
            'description'    => 'nullable|string',
            'requirements'   => 'nullable|string',
            'estimated_time' => 'nullable|string|max:100',
            'fee'            => 'nullable|string|max:100',
            'order'          => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
        ]);

        $requirementsText = $request->requirements;
        $requirements = [];
        if (!empty($requirementsText)) {
            $requirements = array_filter(array_map('trim', explode("\n", $requirementsText)));
            $requirements = array_values($requirements);
        }

        $serviceType->update([
            'name'           => $request->name,
            'code'           => strtoupper($request->code),
            'description'    => $request->description,
            'requirements'   => $requirements,
            'estimated_time' => $request->estimated_time,
            'fee'            => $request->fee,
            'order'          => $request->order ?? 0,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.service-types.index')
            ->with('success', 'Jenis layanan berhasil diperbarui.');
    }

    public function destroy(ServiceType $serviceType)
    {
        if ($serviceType->requests()->count() > 0) {
            return back()->with('error', 'Layanan tidak dapat dihapus karena masih memiliki pengajuan aktif.');
        }
        $serviceType->delete();
        return redirect()->route('admin.service-types.index')
            ->with('success', 'Jenis layanan berhasil dihapus.');
    }
}
