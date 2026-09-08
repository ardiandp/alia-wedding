<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lead::with(['venue', 'assignedTo']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $leads = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.leads.index', compact('leads'));
    }

    public function show(Lead $lead): View
    {
        $lead->load(['venue', 'assignedTo', 'notes.user', 'consultations', 'services']);

        $users = User::where('role', '!=', 'user')->orderBy('name')->get();

        return view('admin.leads.show', compact('lead', 'users'));
    }

    public function updateStatus(Request $request, Lead $lead): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:'.implode(',', Lead::STATUSES)],
        ]);

        $lead->update([
            'status' => $request->status,
            'last_contact_at' => now(),
        ]);

        return back()->with('success', 'Status lead berhasil diperbarui.');
    }

    public function assign(Request $request, Lead $lead): RedirectResponse
    {
        $request->validate([
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $lead->update([
            'assigned_to' => $request->assigned_to,
        ]);

        return back()->with('success', 'Penugasan lead berhasil diperbarui.');
    }

    public function storeNote(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'note' => ['required', 'string'],
        ]);

        LeadNote::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'note' => $validated['note'],
        ]);

        return back()->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function storeConsultation(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'scheduled_at' => ['required', 'date'],
            'scheduled_time' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        Consultation::create([
            'lead_id' => $lead->id,
            'scheduled_at' => $validated['scheduled_at'],
            'scheduled_time' => $validated['scheduled_time'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'scheduled',
        ]);

        return back()->with('success', 'Konsultasi berhasil dijadwalkan.');
    }
}
