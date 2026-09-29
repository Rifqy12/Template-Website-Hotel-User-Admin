@extends('layouts.app')

@section('title', 'Riwayat Pemesanan')

@section('content')
<style>
    .my-bookings-container {
        max-width: 1200px;
        margin: 6rem auto 4rem;
        padding: 0 2rem;
    }

    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-header h1 {
        font-size: 2.5rem;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .page-header p {
        color: #666;
        font-size: 1.1rem;
    }

    .bookings-grid {
        display: grid;
        gap: 2rem;
    }

    .booking-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .booking-header {
        background: linear-gradient(135deg, var(--primary-color), #c9a961);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .booking-id {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .booking-body {
        padding: 2rem;
    }

    .booking-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-group {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .info-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .info-value {
        font-size: 1.1rem;
        color: var(--secondary-color);
        font-weight: 600;
    }

    .room-details {
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .room-details h3 {
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
        font-size: 1.3rem;
    }

    .room-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-top: 1rem;
        color: #666;
    }

    .room-meta span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .total-price {
        background: var(--primary-color);
        color: var(--secondary-color);
        padding: 1rem 1.5rem;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .booking-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .booking-actions form {
        display: inline-flex;
    }

    .btn {
        padding: 0.7rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-detail {
        background: var(--primary-color);
        color: var(--secondary-color);
    }

    .btn-detail:hover {
        background: #c9a961;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: #dc3545;
        color: #fff;
    }

    .btn-cancel:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .empty-state h2 {
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 2rem;
    }

    .btn-primary {
        background: var(--primary-color);
        color: var(--secondary-color);
        padding: 1rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #c9a961;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .my-bookings-container {
            margin-top: 5rem;
            padding: 0 1rem;
        }

        .page-header h1 {
            font-size: 2rem;
        }

        .booking-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .booking-info {
            grid-template-columns: 1fr;
        }

        .booking-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="my-bookings-container">
    <div class="page-header">
        <h1><i class="fas fa-history"></i> Riwayat Pemesanan</h1>
        <p>Lihat semua pemesanan yang pernah Anda buat</p>
    </div>

    @if($bookings->count() > 0)
        <div class="bookings-grid">
            @foreach($bookings as $booking)
                <div class="booking-card">
                    <div class="booking-header">
                        <span class="booking-id">
                            <i class="fas fa-receipt"></i> 
                            Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="status-badge status-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="booking-body">
                        <div class="room-details">
                            <h3>{{ optional($booking->room)->type ?? 'Kamar' }} - Kamar {{ optional($booking->room)->number ?? '-' }}</h3>
                            <div class="room-meta">
                                <span>
                                    <i class="fas fa-users"></i>
                                    {{ $booking->number_of_guests }} Tamu
                                </span>
                                <span>
                                    <i class="fas fa-moon"></i>
                                    {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} Malam
                                </span>
                                <span>
                                    <i class="fas fa-bed"></i>
                                    Kapasitas {{ optional($booking->room)->capacity ?? '-' }} orang
                                </span>
                            </div>
                        </div>

                        <div class="booking-info">
                            <div class="info-group">
                                <span class="info-label">Check-in</span>
                                <span class="info-value">
                                    <i class="fas fa-calendar-check"></i>
                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                                </span>
                            </div>
                            <div class="info-group">
                                <span class="info-label">Check-out</span>
                                <span class="info-value">
                                    <i class="fas fa-calendar-times"></i>
                                    {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                                </span>
                            </div>
                            <div class="info-group">
                                <span class="info-label">Tanggal Pesan</span>
                                <span class="info-value">
                                    <i class="fas fa-clock"></i>
                                    {{ $booking->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="total-price">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>

                        <div class="booking-actions">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-detail">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>

                            @if(($booking->payment_status ?? 'unpaid') !== 'paid' && $booking->status !== 'cancelled')
                                <a href="{{ route('bookings.pay', $booking->id) }}" class="btn btn-detail">
                                    <i class="fas fa-credit-card"></i> Bayar
                                </a>
                            @endif
                            
                            @if($booking->status === 'confirmed')
                                <a href="{{ route('bookings.confirmation', $booking->id) }}" class="btn btn-detail">
                                    <i class="fas fa-file-download"></i> Download Konfirmasi
                                </a>
                            @endif

                            @if($booking->status === 'pending')
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-cancel">
                                        <i class="fas fa-times-circle"></i> Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h2>Belum Ada Pemesanan</h2>
            <p>Anda belum melakukan pemesanan kamar. Mulai pesan sekarang untuk menikmati pengalaman menginap terbaik!</p>
            <a href="{{ route('rooms.index') }}" class="btn-primary">
                <i class="fas fa-search"></i> Cari Kamar
            </a>
        </div>
    @endif
</div>
@endsection
