<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'full_name', 'partner_name', 'email', 'whatsapp', 'wedding_date',
    'estimated_guests', 'venue_id', 'preferred_venue', 'wedding_style',
    'budget_range', 'message', 'status', 'assigned_to', 'last_contact_at',
])]
class Lead extends Model
{
    public const STATUSES = [
        'new', 'contacted', 'consultation', 'proposal_sent',
        'negotiation', 'confirmed', 'completed', 'cancelled',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'estimated_guests' => 'integer',
        'last_contact_at' => 'datetime',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'lead_services');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class)->latest();
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }
}
