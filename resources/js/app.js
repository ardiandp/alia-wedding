import Alpine from 'alpinejs';

import './media-picker';
import './seo-fields';

window.Alpine = Alpine;

Alpine.start();

// ---------------------------------------------------------------------------
// Click tracking (WhatsApp / phone / email / contact)
// ---------------------------------------------------------------------------
const TRACK_PATTERNS = [
    [/^https?:\/\/(www\.)?wa\.me\//i, 'whatsapp'],
    [/^tel:/i, 'phone'],
    [/^mailto:/i, 'email'],
];

function inferTrackLabel(anchor) {
    const explicit = anchor.getAttribute('data-track');
    if (explicit) return explicit;

    const href = anchor.getAttribute('href') || '';

    for (const [pattern, label] of TRACK_PATTERNS) {
        if (pattern.test(href)) return label;
    }

    if (/\/contact\b/i.test(href)) return 'contact';

    return null;
}

function sendTrackClick(anchor) {
    if (window.location.pathname.startsWith('/admin')) return;

    const label = inferTrackLabel(anchor);
    if (!label) return;

    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    const payload = {
        label,
        path: window.location.pathname,
        target: (anchor.getAttribute('href') || '').slice(0, 255),
    };

    try {
        fetch('/track/click', {
            method: 'POST',
            keepalive: true,
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                ...(token ? { 'X-CSRF-TOKEN': token } : {}),
            },
            body: JSON.stringify(payload),
        });
    } catch (error) {
        // Analytics must never break navigation.
    }
}

document.addEventListener(
    'click',
    (event) => {
        const anchor = event.target instanceof Element
            ? event.target.closest('a[href]')
            : null;

        if (anchor) sendTrackClick(anchor);
    },
    { capture: true, passive: true }
);