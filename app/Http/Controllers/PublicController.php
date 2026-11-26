<?php

namespace App\Http\Controllers;

use App\Models\VillageProfile;
use App\Models\VillageOfficial;
use App\Models\News;
use App\Models\Event;
use App\Models\ServiceType;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicController extends Controller
{
    /**
     * Halaman Beranda
     */
    public function home()
    {
        $profile = VillageProfile::first();
        $latestNews = News::published()->limit(3)->get();
        $upcomingEvents = Event::whereIn('status', ['upcoming', 'ongoing'])
            ->orderBy('start_datetime', 'asc')
            ->limit(3)
            ->get();

        return view('public.home', compact('profile', 'latestNews', 'upcomingEvents'));
    }

    /**
     * Halaman Profil Desa
     */
    public function profile()
    {
        $profile = VillageProfile::first();
        $officials = VillageOfficial::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        return view('public.profile', compact('profile', 'officials'));
    }

    /**
     * Daftar Berita
     */
    public function newsList(Request $request)
    {
        $query = News::published()->with('author');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $news = $query->paginate(9)->withQueryString();
        $categories = ['Pemerintahan', 'Pembangunan', 'Sosial', 'Pengumuman'];

        return view('public.news.index', compact('news', 'categories'));
    }

    /**
     * Detail Berita
     */
    public function newsShow(string $slug)
    {
        $news = News::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $news->increment('views');

        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->limit(3)
            ->get();

        return view('public.news.show', compact('news', 'relatedNews'));
    }

    /**
     * Daftar Agenda Kegiatan
     */
    public function eventsList()
    {
        $upcomingEvents = Event::whereIn('status', ['upcoming', 'ongoing'])
            ->orderBy('start_datetime', 'asc')
            ->get();

        $completedEvents = Event::where('status', 'completed')
            ->orderBy('start_datetime', 'desc')
            ->limit(5)
            ->get();

        return view('public.events.index', compact('upcomingEvents', 'completedEvents'));
    }

    /**
     * Halaman Layanan Masyarakat
     */
    public function servicesList()
    {
        $serviceTypes = ServiceType::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        return view('public.services.index', compact('serviceTypes'));
    }

    /**
     * Form Pengajuan Layanan / Submit
     */
    public function serviceSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'applicant_name' => 'required|string|max:255',
            'nik'            => 'required|string|digits:16',
            'phone'          => 'required|string|max:20',
            'service_type_id'=> 'required|exists:service_types,id',
            'description'    => 'nullable|string|max:1000',
        ], [
            'applicant_name.required' => 'Nama lengkap wajib diisi.',
            'nik.required'            => 'NIK wajib diisi.',
            'nik.digits'              => 'NIK harus berupa 16 digit angka.',
            'phone.required'          => 'Nomor HP/WA wajib diisi.',
            'service_type_id.required'=> 'Jenis layanan wajib dipilih.',
            'service_type_id.exists'  => 'Jenis layanan tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $trackingCode = ServiceRequest::generateTrackingCode();

        $serviceRequest = ServiceRequest::create([
            'tracking_code'   => $trackingCode,
            'service_type_id' => $request->service_type_id,
            'applicant_name'  => $request->applicant_name,
            'nik'             => $request->nik,
            'phone'           => $request->phone,
            'description'     => $request->description,
            'status'          => 'menunggu',
        ]);

        return back()->with('success', "Pengajuan berhasil! Kode tracking Anda: **{$trackingCode}**. Simpan kode ini untuk memantau status pengajuan Anda.");
    }

    /**
     * Cek Status Pengajuan
     */
    public function serviceTrack(Request $request)
    {
        $result = null;
        $error = null;

        if ($request->filled('tracking_code')) {
            $result = ServiceRequest::with('serviceType')
                ->where('tracking_code', strtoupper(trim($request->tracking_code)))
                ->first();

            if (!$result) {
                $error = 'Kode tracking tidak ditemukan. Pastikan kode yang Anda masukkan sudah benar.';
            }
        }

        return view('public.services.track', compact('result', 'error'));
    }
}
