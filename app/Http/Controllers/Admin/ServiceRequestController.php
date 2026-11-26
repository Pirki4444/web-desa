<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::with('serviceType')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('tracking_code', 'like', '%' . $request->search . '%')
                  ->orWhere('applicant_name', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        $requests = $query->paginate(15)->withQueryString();

        $statusCounts = [
            'all'      => ServiceRequest::count(),
            'menunggu' => ServiceRequest::where('status', 'menunggu')->count(),
            'diproses' => ServiceRequest::where('status', 'diproses')->count(),
            'selesai'  => ServiceRequest::where('status', 'selesai')->count(),
            'ditolak'  => ServiceRequest::where('status', 'ditolak')->count(),
        ];

        return view('admin.service_requests.index', compact('requests', 'statusCounts'));
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load('serviceType', 'processor');
        return view('admin.service_requests.show', compact('serviceRequest'));
    }

    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'status'     => 'required|in:menunggu,diproses,selesai,ditolak',
            'admin_note' => 'nullable|string|max:1000',
        ], [
            'status.required' => 'Status wajib dipilih.',
        ]);

        $serviceRequest->update([
            'status'       => $request->status,
            'admin_note'   => $request->admin_note,
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.service-requests.show', $serviceRequest)
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function destroy(ServiceRequest $serviceRequest)
    {
        $serviceRequest->delete();
        return redirect()->route('admin.service-requests.index')
            ->with('success', 'Data pengajuan berhasil dihapus.');
    }
}
