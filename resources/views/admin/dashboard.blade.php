@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
@php
    $statusMax = 0;
    foreach (($stats['bookings_by_status'] ?? []) as $row) {
        $statusMax = max($statusMax, (int) ($row['count'] ?? 0));
    }

    $paymentMax = 0;
    foreach (($stats['bookings_by_payment_status'] ?? []) as $row) {
        $paymentMax = max($paymentMax, (int) ($row['count'] ?? 0));
    }
@endphp

<style>
    .chart {
        display: grid;
        gap: 0.75rem;
    }
    .chart-row {
        display: grid;
        grid-template-columns: 140px 1fr 80px;
        gap: 0.75rem;
        align-items: center;
    }
    .chart-label {
        color: var(--secondary-color);
        font-weight: 600;
        text-transform: capitalize;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .chart-bar {
        height: 12px;
        border-radius: 999px;
        background: #eef2f6;
        overflow: hidden;
    }
    .chart-bar > span {
        display: block;
        height: 100%;
        background: var(--primary-color);
        border-radius: 999px;
        width: 0;
    }
    .chart-value {
        color: var(--text-color);
        font-weight: 700;
        text-align: right;
    }
    @media (max-width: 520px) {
        .chart-row {
            grid-template-columns: 1fr;
            gap: 0.4rem;
        }
        .chart-value {
            text-align: left;
        }
    }
</style>

<div style="max-width: 1200px; margin: 0 auto;">
    <div style="display:flex; align-items:flex-end; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; color: var(--secondary-color);">Dashboard Admin</h1>
            <p style="margin: 0.35rem 0 0; color: var(--accent-color);">Ringkasan statistik pemesanan dan ketersediaan kamar.</p>
        </div>
    </div>

    <div style="margin-top: 1.25rem; background: var(--white); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #eee; display:flex; align-items:center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
            <h2 style="margin: 0; font-size: 1.1rem; color: var(--secondary-color);">Statistik Utama</h2>
            <div style="color: var(--accent-color); font-size: 0.9rem;">Update: {{ now()->format('d M Y, H:i') }}</div>
        </div>

        <div style="padding: 1.25rem; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 650px;">
                <thead>
                    <tr style="text-align:left; color: var(--secondary-color);">
                        <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Metode</th>
                        <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Nilai</th>
                        <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Keterangan</th>
                    </tr>
                </thead>
                <tbody style="color: var(--text-color);">
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2;">Total Booking</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; font-weight: 700;">{{ number_format($stats['bookings_total']) }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; color: var(--accent-color);">Semua pemesanan di sistem</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2;">Booking Hari Ini</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; font-weight: 700;">{{ number_format($stats['bookings_today']) }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; color: var(--accent-color);">Dibuat pada tanggal hari ini</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2;">Booking Bulan Ini</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; font-weight: 700;">{{ number_format($stats['bookings_month']) }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; color: var(--accent-color);">Dibuat pada bulan berjalan</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2;">Total Kamar</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; font-weight: 700;">{{ number_format($stats['rooms_total']) }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; color: var(--accent-color);">Jumlah kamar terdaftar</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem;">Kamar Available</td>
                        <td style="padding: 0.75rem; font-weight: 700;">{{ number_format($stats['rooms_available']) }}</td>
                        <td style="padding: 0.75rem; color: var(--accent-color);">Siap untuk dipesan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 1.25rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.25rem;">
        <div style="background: var(--white); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 1.1rem; color: var(--secondary-color);">Booking per Status</h2>
            </div>
            <div style="padding: 1.25rem;">
                @if(empty($stats['bookings_by_status']))
                    <div style="color: var(--accent-color);">Belum ada data booking.</div>
                @else
                    <div class="chart">
                        @foreach($stats['bookings_by_status'] as $row)
                            @php
                                $count = (int) ($row['count'] ?? 0);
                                $pct = $statusMax > 0 ? ($count / $statusMax) * 100 : 0;
                            @endphp
                            <div class="chart-row">
                                <div class="chart-label">{{ $row['status'] }}</div>
                                <div class="chart-bar" aria-label="{{ $row['status'] }}" title="{{ $row['status'] }}: {{ number_format($count) }}">
                                    <span data-pct="{{ number_format($pct, 2, '.', '') }}"></span>
                                </div>
                                <div class="chart-value">{{ number_format($count) }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div style="background: var(--white); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 1.1rem; color: var(--secondary-color);">Pembayaran</h2>
            </div>
            <div style="padding: 1.25rem;">
                @if(empty($stats['bookings_by_payment_status']))
                    <div style="color: var(--accent-color);">Belum ada data pembayaran.</div>
                @else
                    <div class="chart">
                        @foreach($stats['bookings_by_payment_status'] as $row)
                            @php
                                $count = (int) ($row['count'] ?? 0);
                                $pct = $paymentMax > 0 ? ($count / $paymentMax) * 100 : 0;
                            @endphp
                            <div class="chart-row">
                                <div class="chart-label">{{ $row['payment_status'] }}</div>
                                <div class="chart-bar" aria-label="{{ $row['payment_status'] }}" title="{{ $row['payment_status'] }}: {{ number_format($count) }}">
                                    <span data-pct="{{ number_format($pct, 2, '.', '') }}"></span>
                                </div>
                                <div class="chart-value">{{ number_format($count) }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
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
