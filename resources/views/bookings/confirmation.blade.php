@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan - Hotel Paradise')

@section('styles')
<style>
    .receipt-print {
        display: none;
    }

    .receipt {
        width: 76mm;
        max-width: 100%;
        margin: 0 auto;
        color: #000;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        font-size: 15px;
        line-height: 1.35;
    }

    .receipt h1,
    .receipt h2,
    .receipt h3,
    .receipt p {
        margin: 0;
    }

    .receipt-center {
        text-align: center;
    }

    .receipt-muted {
        color: #333;
    }

    .receipt-hr {
        border: none;
        border-top: 1px dashed #000;
        margin: 8px 0;
    }

    .receipt-row {
        display: flex;
        justify-content: space-between;
        gap: 8px;
    }

    .receipt-row > div:last-child {
        text-align: right;
        white-space: nowrap;
    }

    .receipt-strong {
        font-weight: 700;
    }

    .receipt-small {
        font-size: 14px;
    }

    @media print {
        @page {
            size: 80mm auto;
            margin: 2mm;
        }

        body {
            background: #fff !important;
        }

        header.header,
        footer.footer {
            display: none !important;
        }

        main.main-content {
            margin-top: 0 !important;
            min-height: auto !important;
        }

        .confirmation-container {
            display: none !important;
        }

        .receipt-print {
            display: block !important;
        }

        .receipt {
            width: 100% !important;
            margin: 0 !important;
        }

        .no-print {
            display: none !important;
        }
    }

    .confirmation-container {
        max-width: 1100px;
        margin: 6rem auto 4rem;
        padding: 0 5%;
    }

    .success-card {
        background: var(--white);
        padding: 3rem;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        text-align: center;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        animation: scaleIn 0.5s ease;
    }

    .success-icon i {
        font-size: 3rem;
        color: white;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-card h1 {
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .success-card p {
        color: var(--accent-color);
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    .booking-details {
        background: var(--light-bg);
        padding: 2rem;
        border-radius: 15px;
        margin: 2rem 0;
        text-align: left;
    }

    .booking-id {
        text-align: center;
        padding: 1rem;
        background: var(--primary-color);
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .booking-id-label {
        font-size: 0.9rem;
        color: var(--secondary-color);
        font-weight: 600;
    }

    .booking-id-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--secondary-color);
        letter-spacing: 2px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid #ddd;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: var(--accent-color);
        font-weight: 600;
    }

    .detail-value {
        color: var(--text-color);
        font-weight: 500;
        text-align: right;
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-confirmed {
        background: #d4edda;
        color: #155724;
    }

    .total-payment {
        background: var(--primary-color);
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 1.5rem;
    }

    .total-payment .detail-row {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .total-payment .detail-label,
    .total-payment .detail-value {
        color: var(--secondary-color);
        font-size: 1.2rem;
        font-weight: 700;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .info-box {
        background: #d1ecf1;
        border-left: 4px solid #0c5460;
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 2rem;
    }

    .info-box h3 {
        color: #0c5460;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .info-box p {
        color: #0c5460;
        margin: 0.5rem 0;
        font-size: 0.95rem;
    }

    .payment-box {
        background: var(--white);
        border: 1px solid #eee;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        text-align: left;
        overflow: hidden;
    }

    .payment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .payment-header h3 {
        margin: 0;
        color: var(--secondary-color);
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

    .qris-wrap {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.9rem;
        align-items: start;
    }

    .qris-card {
        background: var(--white);
        border-radius: 15px;
        padding: 1.25rem;
        border: 1px solid #eee;
        box-shadow: var(--shadow);
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

    .qris-info {
        width: 100%;
    }

    .qris-qr > img,
    .qris-qr > canvas {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        display: block;
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

    @media (min-width: 900px) {
        .payment-grid {
            grid-template-columns: minmax(320px, 420px) 1fr;
            align-items: start;
        }

        .qris-qr {
            justify-self: center;
        }
    }
</style>
@endsection

@section('content')
@php
    $bookingIdPrint = str_pad($booking->id, 6, '0', STR_PAD_LEFT);
    $guestNamePrint = filled($booking->guest_name) ? $booking->guest_name : ($booking->user?->name ?? '-');
    $guestEmailPrint = filled($booking->guest_email) ? $booking->guest_email : ($booking->user?->email ?? '-');
    $guestPhonePrint = filled($booking->guest_phone) ? $booking->guest_phone : ($booking->user?->phone ?? '-');
    $checkInPrint = \Carbon\Carbon::parse($booking->check_in);
    $checkOutPrint = \Carbon\Carbon::parse($booking->check_out);
    $nightsPrint = $checkInPrint->diffInDays($checkOutPrint);
    $paymentStatusPrint = $booking->payment_status ?? 'unpaid';
@endphp

<div class="receipt-print">
    <div class="receipt">
        <div class="receipt-center">
            <div class="receipt-strong" style="font-size: 16px;">HOTEL PARADISE</div>
            <div class="receipt-muted receipt-small">Konfirmasi Pemesanan</div>
            <div class="receipt-muted receipt-small">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
        </div>

        <hr class="receipt-hr">

        <div class="receipt-row">
            <div>ID Booking</div>
            <div class="receipt-strong">#{{ $bookingIdPrint }}</div>
        </div>
        <div class="receipt-row">
            <div>Status</div>
            <div class="receipt-strong">{{ strtoupper($booking->status) }}</div>
        </div>

        <hr class="receipt-hr">

        <div class="receipt-strong">DATA TAMU</div>
        <div class="receipt-row">
            <div>Nama</div>
            <div>{{ $guestNamePrint }}</div>
        </div>
        <div class="receipt-row">
            <div>Telepon</div>
            <div>{{ $guestPhonePrint }}</div>
        </div>
        <div class="receipt-row">
            <div>Email</div>
            <div>{{ $guestEmailPrint }}</div>
        </div>

        <hr class="receipt-hr">

        <div class="receipt-strong">DETAIL KAMAR</div>
        <div class="receipt-row">
            <div>Kamar</div>
            <div>{{ $booking->room->type }}</div>
        </div>
        <div class="receipt-row">
            <div>No. Kamar</div>
            <div>{{ $booking->room->number }}</div>
        </div>
        <div class="receipt-row">
            <div>Check-in</div>
            <div>{{ $checkInPrint->format('d/m/Y') }}</div>
        </div>
        <div class="receipt-row">
            <div>Check-out</div>
            <div>{{ $checkOutPrint->format('d/m/Y') }}</div>
        </div>
        <div class="receipt-row">
            <div>Malam</div>
            <div>{{ $nightsPrint }}</div>
        </div>

        <hr class="receipt-hr">

        <div class="receipt-strong">RINGKASAN BIAYA</div>
        <div class="receipt-row">
            <div>Harga/malam</div>
            <div>Rp {{ number_format($booking->room->price, 0, ',', '.') }}</div>
        </div>
        <div class="receipt-row">
            <div>Subtotal</div>
            <div>Rp {{ number_format($booking->room->price * $nightsPrint, 0, ',', '.') }}</div>
        </div>
        <div class="receipt-row" style="margin-top: 4px;">
            <div class="receipt-strong">TOTAL</div>
            <div class="receipt-strong">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
        </div>

        <hr class="receipt-hr">

        <div class="receipt-strong">PEMBAYARAN</div>
        <div class="receipt-row">
            <div>Status</div>
            <div class="receipt-strong">{{ $paymentStatusPrint === 'paid' ? 'PAID' : 'UNPAID' }}</div>
        </div>
        <div class="receipt-row">
            <div>Metode</div>
            <div>{{ $booking->payment_method ? strtoupper(str_replace('_', ' ', $booking->payment_method)) : '-' }}</div>
        </div>
        @if($booking->payment_reference)
            <div class="receipt-row">
                <div>Referensi</div>
                <div>{{ $booking->payment_reference }}</div>
            </div>
        @endif
        @if($booking->paid_at)
            <div class="receipt-row">
                <div>Waktu bayar</div>
                <div>{{ \Carbon\Carbon::parse($booking->paid_at)->format('d/m/Y H:i') }}</div>
            </div>
        @endif

        <hr class="receipt-hr">

        <div class="receipt-small receipt-muted">
            Check-in mulai 14:00 WIB • Check-out maksimal 12:00 WIB
        </div>

        <hr class="receipt-hr">

        <div class="receipt-center receipt-small">
            Terima kasih
            <div class="receipt-muted">Hotel Paradise</div>
        </div>
    </div>
</div>

<div class="confirmation-container">
    <div class="success-card no-print">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1>Pemesanan Berhasil!</h1>
        <p>Terima kasih telah mempercayai Hotel Paradise. Pemesanan Anda telah kami terima.</p>

        <div class="booking-details">
            <div class="booking-id">
                <div class="booking-id-label">ID PEMESANAN</div>
                <div class="booking-id-value">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>

            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-bed"></i> Kamar</span>
                <span class="detail-value">{{ $booking->room->type }} - Kamar {{ $booking->room->number }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-user"></i> Nama Tamu</span>
                <span class="detail-value">{{ $booking->user->name }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-envelope"></i> Email</span>
                <span class="detail-value">{{ $booking->user->email }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calendar-check"></i> Check-in</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d F Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calendar-times"></i> Check-out</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d F Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-moon"></i> Jumlah Malam</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }} malam</span>
            </div>

            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-info-circle"></i> Status</span>
                <span class="detail-value">
                    <span class="status-badge status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </span>
            </div>

            <div class="total-payment">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-money-bill-wave"></i> Total Pembayaran</span>
                    <span class="detail-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @php
            $payStatus = $booking->payment_status ?? 'unpaid';
            $payMethod = $booking->payment_method;
            $bookingCode = str_pad($booking->id, 6, '0', STR_PAD_LEFT);
            $amountInt = (int) round($booking->total_price);
            $qrisPayload = "HOTELPARADISE|BOOKING#{$bookingCode}|AMOUNT={$amountInt}|IDR";
        @endphp

        <div class="payment-box" id="payment">
            <div class="payment-header">
                <h3><i class="fas fa-qrcode"></i> Pembayaran</h3>
                <span class="pay-status {{ $payStatus === 'paid' ? 'pay-paid' : 'pay-unpaid' }}">
                    {{ $payStatus === 'paid' ? 'Sudah dibayar' : 'Belum dibayar' }}
                </span>
            </div>

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

        <div class="action-buttons">
            <a href="{{ route('home') }}" class="btn-secondary">
                <i class="fas fa-home"></i> Kembali ke Home
            </a>
            <a href="{{ route('rooms.index') }}" class="btn-primary">
                <i class="fas fa-bed"></i> Pesan Kamar Lain
            </a>
        </div>

        <div class="info-box">
            <h3><i class="fas fa-info-circle"></i> Informasi Penting</h3>
            <p><strong>Check-in:</strong> Mulai pukul 14:00 WIB</p>
            <p><strong>Check-out:</strong> Maksimal pukul 12:00 WIB</p>
            <p><strong>Konfirmasi:</strong> Email konfirmasi telah dikirim ke {{ $booking->user->email }}</p>
            <p><strong>Pembayaran:</strong> Dapat dilakukan saat check-in atau melalui transfer bank</p>
            <p><strong>Bantuan:</strong> Hubungi kami di +62 707 555333 untuk pertanyaan</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<script>
    // Auto print option
    setTimeout(() => {
        const print = confirm('Apakah Anda ingin mencetak konfirmasi pemesanan?');
        if (print) {
            window.print();
        }
    }, 1000);

    // QRIS (simulasi) - generate QR di browser
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
