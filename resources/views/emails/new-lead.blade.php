<x-mail::message>
# New Consultation Request

Seorang calon customer baru telah mengirim permintaan konsultasi melalui website.

<strong>Nama:</strong> {{ $lead->full_name }}
@if($lead->partner_name)
<strong>Pasangan:</strong> {{ $lead->partner_name }}
@endif
<strong>Email:</strong> {{ $lead->email }}
<strong>WhatsApp:</strong> {{ $lead->whatsapp }}
@if($lead->wedding_date)
<strong>Tanggal Pernikahan:</strong> {{ $lead->wedding_date->format('d M Y') }}
@endif
@if($lead->estimated_guests)
<strong>Estimasi Tamu:</strong> {{ $lead->estimated_guests }}
@endif
@if($lead->preferred_venue)
<strong>Preferred Venue:</strong> {{ $lead->preferred_venue }}
@endif
@if($lead->wedding_style)
<strong>Wedding Style:</strong> {{ $lead->wedding_style }}
@endif
@if($lead->budget_range)
<strong>Budget Range:</strong> {{ $lead->budget_range }}
@endif
@if($lead->services->isNotEmpty())
<strong>Layanan:</strong> {{ $lead->services->pluck('name')->join(', ') }}
@endif
@if($lead->message)
<strong>Pesan:</strong><br>
{{ $lead->message }}
@endif

<x-mail::button :url="route('admin.leads.show', $lead)">
Kelola Lead Ini
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
