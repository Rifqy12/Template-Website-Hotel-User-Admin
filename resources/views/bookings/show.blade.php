@extends('layouts.app')

@section('title', 'Detail Booking #' . $booking->id)

@section('content')
<style>
    .booking-detail-container {
        max-width: 900px;
        margin: 6rem auto 4rem;
        padding: 0 2rem;
    }

    .booking-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .booking-header h1 {
        font-size: 2.5rem;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .booking-id {
        font-size: 1.2rem;
        color: var(--primary-color);
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        margin-top: 1rem;
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

    .booking-details {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .detail-section {
        padding: 2rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.3rem;
        color: var(--secondary-color);
        margin-bottom: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--primary-color);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .detail-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .detail-value {
        font-size: 1.1rem;
        color: var(--secondary-color);
        font-weight: 600;
    }

    .room-info {
        background: linear-gradient(135deg, var(--primary-color), #c9a961);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .room-info h3 {
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }

    .room-info p {
        opacity: 0.9;
        line-height: 1.6;
    }

    .price-summary {
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 1.5rem;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 0.8rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .price-row:last-child {
        border-bottom: none;
        padding-top: 1rem;
        margin-top: 0.5rem;
        border-top: 2px solid var(--primary-color);
    }

    .price-row.total {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.8rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-back {
        background: #f3f4f6;
        color: var(--secondary-color);
    }

    .btn-back:hover {
        background: #e5e7eb;
        transform: translateY(-2px);
    }

    .btn-primary {
        background: var(--primary-color);
        color: var(--secondary-color);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .btn-primary:hover {
        background: #c9a961;
        transform: translateY(-2px);
    }

    .date-change-card {
        margin-top: 1.5rem;
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #fdfbf6, #f8f4e8);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }

    .date-change-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: var(--secondary-color);
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .date-change-header i {
        color: var(--primary-color);
    }

    .date-change-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .date-field {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        font-weight: 600;
        color: var(--secondary-color);
    }

    .date-input-shell {
        position: relative;
        display: flex;
        align-items: center;
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 0.4rem 0.75rem;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
    }

    .date-input-shell i {
        color: var(--primary-color);
        margin-right: 0.5rem;
    }

    .date-input-shell input[type="date"] {
        border: none;
        width: 100%;
        padding: 0.35rem 0.25rem;
        font-weight: 600;
        color: var(--secondary-color);
        background: transparent;
        outline: none;
    }

    .date-change-note {
        margin-top: 0.5rem;
        color: #4b5563;
        font-size: 0.92rem;
    }

    @media (max-width: 768px) {
        .booking-detail-container {
            margin-top: 5rem;
            padding: 0 1rem;
        }

        .booking-header h1 {
            font-size: 2rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            .alert-success { background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; padding:0.75rem 1rem; border-radius:10px; }
            .alert-error { background:#fef2f2; color:#991b1b; border:1px solid #fecdd3; padding:0.75rem 1rem; border-radius:10px; }
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="booking-detail-container">
    <div class="booking-header">
        <h1>Detail Booking</h1>
        <p class="booking-id">Booking ID: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
        <span class="status-badge status-{{ $booking->status }}">
            {{ ucfirst($booking->status) }}
        </span>
        @if(session('success'))
            <div class="alert alert-success" style="margin-top:1rem; padding:0.75rem 1rem; border-radius:10px; background:#ecfdf3; color:#166534;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error" style="margin-top:1rem; padding:0.75rem 1rem; border-radius:10px; background:#fef2f2; color:#991b1b;">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <div class="booking-details">
        <!-- Room Information -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-door-open"></i>
                Informasi Kamar
            </h2>
            <div class="room-info">
                <h3>{{ $booking->room->type }} - Kamar {{ $booking->room->number }}</h3>
                <p>{{ $booking->room->description }}</p>
                <p style="margin-top: 1rem;">
                    <i class="fas fa-users"></i> Kapasitas: {{ $booking->room->capacity }} orang
                </p>
            </div>
        </div>

        <!-- Guest Information -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-user"></i>
                Informasi Tamu
            </h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Nama Lengkap</span>
                    <span class="detail-value">{{ filled($booking->guest_name) ? $booking->guest_name : ($booking->user?->name ?? '-') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ filled($booking->guest_email) ? $booking->guest_email : ($booking->user?->email ?? '-') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Nomor Telepon</span>
                    <span class="detail-value">{{ filled($booking->guest_phone) ? $booking->guest_phone : ($booking->user?->phone ?? '-') }}</span>
                </div>
                @if($booking->user)
                <div class="detail-item">
                    <span class="detail-label">Akun User</span>
                    <span class="detail-value">{{ $booking->user->name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Nomor Identitas</span>
                    <span class="detail-value">{{ $booking->user->id_number ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Alamat</span>
                    <span class="detail-value">{{ $booking->user->address ?? '-' }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Booking Information -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-calendar-alt"></i>
                Informasi Pemesanan
            </h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Check-in</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d F Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Check-out</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d F Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Jumlah Malam</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} malam
                    </span>
                </div>
            </div>

            @if(auth()->check() && auth()->id() === $booking->user_id && $booking->status === 'pending')
            <div class="date-change-card">
                <div class="date-change-header">
                    <i class="fas fa-edit"></i>
                    <span>Ubah Tanggal</span>
                </div>
                <form action="{{ route('bookings.update-dates', $booking->id) }}" method="POST" class="date-change-form">
                    @csrf
                    @method('PATCH')
                    <div class="date-field">
                        <label for="check_in">Check-in baru</label>
                        <div class="date-input-shell">
                            <i class="fas fa-calendar-day"></i>
                            <input type="date" id="check_in" name="check_in" required min="{{ date('Y-m-d') }}" value="{{ old('check_in', \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="date-field">
                        <label for="check_out">Check-out baru</label>
                        <div class="date-input-shell">
                            <i class="fas fa-calendar-check"></i>
                            <input type="date" id="check_out" name="check_out" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('check_out', \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="fas fa-save"></i> Simpan Tanggal</button>
                    </div>
                </form>
                <p class="date-change-note">Perubahan tergantung ketersediaan kamar di tanggal baru.</p>
            </div>
            @endif

            @if($booking->special_requests)
            <div style="margin-top: 1.5rem;">
                <span class="detail-label">Permintaan Khusus</span>
                <p style="margin-top: 0.5rem; color: var(--secondary-color); line-height: 1.6;">
                    {{ $booking->special_requests }}
                </p>
            </div>
            @endif
        </div>

        <!-- Payment Information -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-credit-card"></i>
                Informasi Pembayaran
            </h2>
            
            <div class="price-summary">
                <div class="price-row">
                    <span>Harga per Malam</span>
                    <span>Rp {{ number_format($booking->room->price, 0, ',', '.') }}</span>
                </div>
                <div class="price-row">
                    <span>Jumlah Malam</span>
                    <span>{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} malam</span>
                </div>
                <div class="price-row total">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('bookings.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        @else
            <a href="{{ route('bookings.history') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
            </a>
        @endif
    </div>
</div>
@endsection
