@extends('layouts.app')

@section('title', 'Pembayaran - Hotel Paradise')

@section('styles')
<style>
    .payment-page-container {
        max-width: 900px;
        margin: 6rem auto 4rem;
        padding: 0 5%;
    }

    .payment-page-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        padding: 2.5rem;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .page-header h1 {
        margin: 0;
        color: var(--secondary-color);
        font-size: 2rem;
    }

    .subtext {
        margin: 0.35rem 0 0;
        color: var(--accent-color);
    }

    .summary {
        background: var(--light-bg);
        border-radius: 15px;
        padding: 1.25rem;
        margin: 1.25rem 0 1.5rem;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        border-bottom: 1px solid #ddd;
        padding: 0.7rem 0;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-label {
        color: var(--accent-color);
        font-weight: 600;
    }

    .summary-value {
        color: var(--text-color);
        font-weight: 600;
        text-align: right;
    }

    .pay-status {
        display: inline-block;
        padding: 0.45rem 0.9rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .pay-unpaid {
        background: #fff3cd;
        color: #856404;
    }

    .pay-paid {
        background: #d4edda;
        color: #155724;
    }

    .payment-box {
        background: var(--white);
        border: 1px solid #eee;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: left;
        overflow: hidden;
    }

    .payment-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }

    .method-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .method-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.9rem 1rem;
        border: 1px solid #ddd;
        border-radius: 12px;
        cursor: pointer;
        transition: border-color 0.2s ease;
    }

    .method-item:hover {
        border-color: var(--primary-color);
    }

    .method-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .method-left i {
        color: var(--primary-color);
        font-size: 1.25rem;
        width: 24px;
        text-align: center;
    }

    .method-title {
        font-weight: 700;
        color: var(--secondary-color);
    }

    .method-desc {
        font-size: 0.9rem;
        color: var(--accent-color);
    }

    .qris-card {
        background: var(--white);
        border-radius: 15px;
        padding: 1.25rem;
        border: 1px solid #eee;
        box-shadow: var(--shadow);
    }

    .qris-wrap {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.9rem;
        align-items: start;
        justify-items: center;
    }

    .qris-qr {
        width: 240px;
        height: 240px;
        background: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eee;
        overflow: hidden;
    }

    .qris-qr > img,
    .qris-qr > canvas {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        display: block;
    }

    .qris-info {
        width: 100%;
    }

    .qris-hint {
        font-size: 0.95rem;
        color: var(--text-color);
        margin: 0;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .field-row label {
        font-weight: 600;
        color: var(--text-color);
        font-size: 0.95rem;
    }

    .field-row input {
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 1rem;
    }

    .payment-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .note-small {
        margin-top: 0.75rem;
        font-size: 0.9rem;
        color: var(--accent-color);
    }

    .action-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1.75rem;
    }
</style>
@endsection

@section('content')
@php
    $payStatus = $booking->payment_status ?? 'unpaid';
    $payMethod = $booking->payment_method;
    $bookingCode = str_pad($booking->id, 6, '0', STR_PAD_LEFT);
    $amountInt = (int) round($booking->total_price);
    $qrisPayload = "HOTELPARADISE|BOOKING#{$bookingCode}|AMOUNT={$amountInt}|IDR";
@endphp

<div class="payment-page-container">
    <div class="payment-page-card">
        <div class="page-header">
            <div>
                <h1><i class="fas fa-credit-card"></i> Pembayaran</h1>
                <p class="subtext">Silakan pilih metode pembayaran untuk Booking #{{ $bookingCode }}.</p>
            </div>
            <span class="pay-status {{ $payStatus === 'paid' ? 'pay-paid' : 'pay-unpaid' }}">
                {{ $payStatus === 'paid' ? 'Sudah dibayar' : 'Belum dibayar' }}
            </span>
        </div>

        <div class="summary">
            <div class="summary-grid">
                <div class="summary-row">
                    <span class="summary-label">Kamar</span>
                    <span class="summary-value">{{ $booking->room->type }} - Kamar {{ $booking->room->number }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Nama</span>
                    <span class="summary-value">{{ $booking->user->name }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Total</span>
                    <span class="summary-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="payment-box" id="payment">
            <div class="payment-grid">
                <div>
                    <p style="margin: 0 0 0.75rem; color: var(--accent-color);">
                        Pilih metode pembayaran (simulasi). Kamu bisa konfirmasi bayar agar status berubah.
                    </p>

                    <form action="{{ route('bookings.payment', $booking->id) }}" method="POST">
                        @csrf

                        <div class="method-list">
                            <label class="method-item">
                                <span class="method-left">
                                    <i class="fas fa-qrcode"></i>
                                    <span>
                                        <div class="method-title">QRIS</div>
                                        <div class="method-desc">Scan QR untuk bayar via aplikasi apa saja</div>
                                    </span>
                                </span>
                                <input type="radio" name="payment_method" value="qris" {{ ($payMethod ?? 'qris') === 'qris' ? 'checked' : '' }}>
                            </label>

                            <label class="method-item">
                                <span class="method-left">
                                    <i class="fas fa-university"></i>
                                    <span>
                                        <div class="method-title">Transfer Bank</div>
                                        <div class="method-desc">BCA / BRI / Mandiri (simulasi)</div>
                                    </span>
                                </span>
                                <input type="radio" name="payment_method" value="bank_transfer" {{ $payMethod === 'bank_transfer' ? 'checked' : '' }}>
                            </label>

                            <label class="method-item">
                                <span class="method-left">
                                    <i class="fas fa-wallet"></i>
                                    <span>
                                        <div class="method-title">E-Wallet</div>
                                        <div class="method-desc">OVO / DANA / GoPay (simulasi)</div>
                                    </span>
                                </span>
                                <input type="radio" name="payment_method" value="ewallet" {{ $payMethod === 'ewallet' ? 'checked' : '' }}>
                            </label>

                            <label class="method-item">
                                <span class="method-left">
                                    <i class="fas fa-store"></i>
                                    <span>
                                        <div class="method-title">Bayar Saat Check-in</div>
                                        <div class="method-desc">Bayar tunai/debit ketika datang</div>
                                    </span>
                                </span>
                                <input type="radio" name="payment_method" value="cash" {{ $payMethod === 'cash' ? 'checked' : '' }}>
                            </label>
                        </div>

                        <div class="field-row">
                            <label for="payment_reference">Catatan / Referensi (opsional)</label>
                            <input
                                id="payment_reference"
                                name="payment_reference"
                                type="text"
                                placeholder="Contoh: Nama pengirim / ID transaksi"
                                value="{{ old('payment_reference', $booking->payment_reference) }}"
                            >
                        </div>

                        <div class="payment-actions">
                            @if(($booking->payment_status ?? 'unpaid') !== 'paid')
                                <button class="btn-primary" type="submit" name="action" value="mark_paid">
                                    <i class="fas fa-check-circle"></i> Konfirmasi Pembayaran
                                </button>
                            @else
                                @if(auth()->check() && (auth()->user()->role === 'admin' || $booking->status !== 'confirmed'))
                                    <button class="btn-secondary" type="submit" name="action" value="mark_unpaid">
                                        <i class="fas fa-undo"></i> Batalkan Status Paid
                                    </button>
                                @endif
                            @endif
                        </div>

                        <div class="note-small">
                            <strong>Catatan:</strong> Ini adalah simulasi untuk kebutuhan demo. Tidak ada transaksi uang asli.
                        </div>
                    </form>
                </div>

                <div>
                    <div class="qris-card">
                        <div class="qris-wrap">
                            <div class="qris-qr" id="qrisQr" data-payload="{{ $qrisPayload }}"></div>
                            <div class="qris-info">
                                <p class="qris-hint" style="margin-bottom: 0.5rem;"><strong>QRIS Hotel Paradise</strong></p>
                                <p class="qris-hint" style="margin-bottom: 0.75rem;">Scan menggunakan aplikasi bank/e-wallet untuk simulasi pembayaran.</p>
                                <div style="display: grid; gap: 0.35rem; font-size: 0.95rem;">
                                    <div><strong>Nominal:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    <div><strong>Booking:</strong> #{{ $bookingCode }}</div>
                                    <div><strong>Nama:</strong> {{ $booking->user->name }}</div>
                                </div>

                                <div style="margin-top: 0.9rem; padding-top: 0.9rem; border-top: 1px solid #ddd;">
                                    <div style="font-weight: 700; color: var(--secondary-color); margin-bottom: 0.35rem;">Instruksi Transfer (Simulasi)</div>
                                    <div style="font-size: 0.95rem; color: var(--text-color);">
                                        BCA: 1234567890 a.n. Hotel Paradise<br>
                                        Mandiri: 9876543210 a.n. Hotel Paradise<br>
                                        BRI: 1122334455 a.n. Hotel Paradise
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-row">
            <a href="{{ route('bookings.history') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
            </a>
            <a href="{{ route('bookings.show', $booking->id) }}" class="btn-primary">
                <i class="fas fa-eye"></i> Lihat Detail Booking
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const qrEl = document.getElementById('qrisQr');
        if (!qrEl || typeof QRCode === 'undefined') return;

        const payload = qrEl.dataset.payload || '';
        qrEl.innerHTML = '';
        const rect = qrEl.getBoundingClientRect();
        const size = Math.max(120, Math.floor(Math.min(rect.width, rect.height)));
        new QRCode(qrEl, {
            text: payload,
            width: size,
            height: size,
            correctLevel: QRCode.CorrectLevel.M,
        });
    });
</script>
@endsection
