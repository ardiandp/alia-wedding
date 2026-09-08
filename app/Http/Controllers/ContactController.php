<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Mail\NewLeadMail;
use App\Models\Lead;
use App\Models\Service;
use App\Models\Venue;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $venues = Venue::where('is_active', true)->orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();

        $weddingStyles = ['Modern', 'Traditional', 'International', 'Intimate', 'Garden', 'Beach'];
        $budgetRanges = [
            'Below Rp 100jt',
            'Rp 100jt - 200jt',
            'Rp 200jt - 500jt',
            'Above Rp 500jt',
        ];

        return view('contact', compact('venues', 'services', 'weddingStyles', 'budgetRanges'));
    }

    public function store(StoreLeadRequest $request)
    {
        $validated = $request->validated();

        $lead = Lead::create([
            'full_name' => $validated['full_name'],
            'partner_name' => $validated['partner_name'] ?? null,
            'email' => $validated['email'],
            'whatsapp' => $validated['whatsapp'],
            'wedding_date' => $validated['wedding_date'] ?? null,
            'estimated_guests' => $validated['estimated_guests'] ?? null,
            'preferred_venue' => $validated['preferred_venue'] ?? null,
            'wedding_style' => $validated['wedding_style'] ?? null,
            'budget_range' => $validated['budget_range'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'new',
        ]);

        if (! empty($validated['services'])) {
            $lead->services()->sync($validated['services']);
        }

        Mail::to(setting('contact_email'))->queue(new NewLeadMail($lead));

        return redirect()->route('contact.thankyou')->with(['lead' => $lead]);
    }

    public function thankyou()
    {
        return view('contact-thankyou');
    }
}
