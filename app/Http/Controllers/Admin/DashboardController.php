<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\ServiceRequest;
use App\Models\VillageProfile;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_news'     => News::where('status', 'published')->count(),
            'total_events'   => Event::count(),
            'total_requests' => ServiceRequest::count(),
            'pending_requests' => ServiceRequest::where('status', 'menunggu')->count(),
        ];

        $recentRequests = ServiceRequest::with('serviceType')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $profile = VillageProfile::first();

        return view('admin.dashboard', compact('stats', 'recentRequests', 'profile'));
    }
}
