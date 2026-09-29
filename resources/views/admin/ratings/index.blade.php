@extends('layouts.app')

@section('title', 'Rating Hotel')

@section('content')
@php
    $count = (int)($ratingStats['count'] ?? 0);
    $avg = (float)($ratingStats['avg'] ?? 0);
    $avgText = $count > 0 ? number_format($avg, 2) : '0.00';
    $dist = $ratingStats['distribution'] ?? [];

    $maxDist = 0;
    foreach ($dist as $v) { $maxDist = max($maxDist, (int)$v); }
@endphp

<style>
    .chart { display: grid; gap: 0.6rem; }
    .chart-row { display: grid; grid-template-columns: 70px 1fr 60px; gap: 0.75rem; align-items: center; }
    .chart-label { color: var(--secondary-color); font-weight: 700; }
    .chart-bar { height: 12px; border-radius: 999px; background: #eef2f6; overflow: hidden; }
    .chart-bar > span { display:block; height: 100%; background: var(--primary-color); border-radius: 999px; width: 0; }
    .chart-value { color: var(--text-color); font-weight: 700; text-align: right; }
</style>

<div style="max-width: 1200px; margin: 0 auto;">
    <div style="display:flex; align-items:flex-end; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; color: var(--secondary-color);">Rating Hotel</h1>
            <p style="margin: 0.35rem 0 0; color: var(--accent-color);">Ringkasan dan daftar rating dari customer.</p>
        </div>
    </div>

    <div style="margin-top: 1.25rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.25rem;">
        <div style="background: var(--white); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 1.1rem; color: var(--secondary-color);">Ringkasan</h2>
            </div>
            <div style="padding: 1.25rem;">
                <div style="font-size: 2.2rem; font-weight: 800; color: var(--secondary-color);">{{ $avgText }}/5</div>
                <div style="margin-top: 0.25rem; color: var(--accent-color);">Total rating: {{ number_format($count) }}</div>

                <div style="margin-top: 1rem;">
                    <div class="chart">
                        @for($star = 5; $star >= 1; $star--)
                            @php
                                $val = (int)($dist[$star] ?? 0);
                                $pct = $maxDist > 0 ? ($val / $maxDist) * 100 : 0;
                            @endphp
                            <div class="chart-row">
                                <div class="chart-label">{{ $star }}★</div>
                                <div class="chart-bar" title="{{ $star }}: {{ number_format($val) }}">
                                    <span data-pct="{{ number_format($pct, 2, '.', '') }}"></span>
                                </div>
                                <div class="chart-value">{{ number_format($val) }}</div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <div style="background: var(--white); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 1.1rem; color: var(--secondary-color);">Daftar Rating</h2>
            </div>

            @if($ratings->isEmpty())
                <div style="padding: 1.25rem; color: var(--accent-color);">Belum ada rating masuk.</div>
            @else
                <div style="padding: 1.25rem; overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 760px;">
                        <thead>
                            <tr style="text-align:left; color: var(--secondary-color);">
                                <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Waktu</th>
                                <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">User</th>
                                <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Email</th>
                                <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Rating</th>
                            </tr>
                        </thead>
                        <tbody style="color: var(--text-color);">
                            @foreach($ratings as $rating)
                                <tr>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; white-space: nowrap; color: var(--accent-color);">
                                        {{ $rating->created_at?->format('d M Y, H:i') }}
                                    </td>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; font-weight: 700;">
                                        {{ $rating->user?->name ?? 'Unknown' }}
                                    </td>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2;">
                                        {{ $rating->user?->email ?? '-' }}
                                    </td>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" style="color: {{ $i <= (int)$rating->rating ? 'var(--primary-color)' : '#ddd' }};"></i>
                                        @endfor
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        (function () {
            const spans = document.querySelectorAll('.chart-bar > span[data-pct]');
            spans.forEach((span) => {
                const pct = Number(span.dataset.pct);
                const safePct = Number.isFinite(pct) ? Math.max(0, Math.min(100, pct)) : 0;
                span.style.width = safePct + '%';
            });
        })();
    </script>
</div>
@endsection
