<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Event;
use App\Models\Lead;
use App\Support\Analytics;

class DashboardController extends Controller
{
    public function index()
    {
        $newLeadsCount = Lead::where('status', 'new')->count();
        $consultationCount = Lead::where('status', 'consultation')->count();
        $confirmedCount = Lead::where('status', 'confirmed')->count();
        $upcomingEventsCount = Event::where('status', 'published')
            ->where('start_date', '>=', now()->startOfDay())
            ->count();

        $recentLeads = Lead::with('assignedTo')->latest()->take(5)->get();

        $upcomingWeddings = Lead::whereIn('status', ['confirmed', 'completed'])
            ->whereNotNull('wedding_date')
            ->where('wedding_date', '>=', now()->startOfDay())
            ->orderBy('wedding_date')
            ->take(6)
            ->get();

        $upcomingConsultations = Consultation::with('lead')
            ->where('status', 'scheduled')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>=', now()->startOfDay())
            ->orderBy('scheduled_at')
            ->take(6)
            ->get();

        $trafficDays = 14;
        $trafficSummary = Analytics::summary($trafficDays);
        $trafficSeries = Analytics::dailySeries($trafficDays);
        $clickCounts = Analytics::clickCounts($trafficDays);

        return view('admin.dashboard', compact(
            'newLeadsCount', 'consultationCount', 'confirmedCount',
            'upcomingEventsCount', 'recentLeads', 'upcomingWeddings',
            'upcomingConsultations', 'trafficSummary', 'trafficSeries', 'clickCounts',
        ));
    }
}
