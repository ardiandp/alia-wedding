@props([
    'series' => [],
    'height' => 220,
])

@php
    use Illuminate\Support\Carbon;

    $points = array_values($series);
    $count = count($points);

    $visitors = array_map(fn ($row) => (int) ($row['visitors'] ?? 0), $points);
    $views = array_map(fn ($row) => (int) ($row['views'] ?? 0), $points);
    $keys = array_keys($series);

    $max = max(1, max(array_merge([1], $visitors, $views)));

    $w = 720;
    $h = 200;
    $padX = 6;
    $padTop = 12;
    $padBottom = 12;
    $usableW = $w - ($padX * 2);
    $usableH = $h - $padTop - $padBottom;

    $x = fn (int $i): float => $count > 1
        ? $padX + ($i / ($count - 1)) * $usableW
        : $w / 2;

    $y = fn (int $value): float => $h - $padBottom - ($value / $max) * $usableH;

    $toLine = function (array $values) use ($y, $x): string {
        $coords = [];
        foreach ($values as $i => $value) {
            $coords[] = round($x($i), 1).','.round($y($value), 1);
        }

        return implode(' ', $coords);
    };

    $visitorLine = $count ? $toLine($visitors) : '';
    $viewsLine = $count ? $toLine($views) : '';

    $area = '';
    if ($count) {
        $area = 'M '.round($x(0), 1).','.($h - $padBottom).' '
            .'L '.str_replace(' ', ' L ', $visitorLine).' '
            .'L '.round($x($count - 1), 1).','.($h - $padBottom).' Z';
    }

    $totalVisitors = array_sum($visitors);
    $totalViews = array_sum($views);
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    <div class="mb-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs">
        <span class="inline-flex items-center gap-2 font-medium text-gray-600 dark:text-gray-300">
            <span class="h-2.5 w-2.5 rounded-full bg-rose-600"></span>
            Pengunjung ({{ number_format($totalVisitors, 0, ',', '.') }})
        </span>
        <span class="inline-flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400">
            <span class="h-2.5 w-2.5 rounded-full bg-rose-300 dark:bg-rose-500/60"></span>
            Tampilan ({{ number_format($totalViews, 0, ',', '.') }})
        </span>
    </div>

    @if ($count === 0)
        <div class="flex items-center justify-center rounded-xl border border-dashed border-gray-300 text-sm text-gray-400 dark:border-gray-700"
             style="height: {{ $height }}px">
            Belum ada data pengunjung.
        </div>
    @else
        <svg viewBox="0 0 {{ $w }} {{ $h }}" preserveAspectRatio="none"
             class="w-full" style="height: {{ $height }}px" role="img"
             aria-label="Grafik pengunjung">
            <defs>
                <linearGradient id="visitorFill" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#e11d48" stop-opacity="0.28" />
                    <stop offset="100%" stop-color="#e11d48" stop-opacity="0" />
                </linearGradient>
            </defs>

            @foreach ([0.25, 0.5, 0.75, 1] as $grid)
                <line x1="{{ $padX }}" x2="{{ $w - $padX }}"
                      y1="{{ round($h - $padBottom - $grid * $usableH, 1) }}"
                      y2="{{ round($h - $padBottom - $grid * $usableH, 1) }}"
                      stroke="currentColor" class="text-gray-200 dark:text-gray-800" stroke-width="1" />
            @endforeach

            <line x1="{{ $padX }}" x2="{{ $w - $padX }}" y1="{{ $h - $padBottom }}" y2="{{ $h - $padBottom }}"
                  stroke="currentColor" class="text-gray-300 dark:text-gray-700" stroke-width="1" />

            <path d="{{ $area }}" fill="url(#visitorFill)" />
            <polyline points="{{ $viewsLine }}" fill="none" stroke="#fda4af" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" />
            <polyline points="{{ $visitorLine }}" fill="none" stroke="#e11d48" stroke-width="2.5"
                      stroke-linecap="round" stroke-linejoin="round" />

            @foreach ($visitors as $i => $value)
                <circle cx="{{ round($x($i), 1) }}" cy="{{ round($y($value), 1) }}" r="2.5" fill="#e11d48">
                    <title>{{ Carbon::parse($keys[$i])->format('d/m/Y') }}: {{ $value }} pengunjung · {{ $views[$i] }} tampilan</title>
                </circle>
            @endforeach
        </svg>

        <div class="mt-2 flex justify-between text-[10px] font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
            @php $step = max(1, (int) ceil($count / 6)); @endphp
            @for ($i = 0; $i < $count; $i += $step)
                <span>{{ Carbon::parse($keys[$i])->format('d/m') }}</span>
            @endfor
            <span>{{ Carbon::parse($keys[$count - 1])->format('d/m') }}</span>
        </div>
    @endif
</div>
