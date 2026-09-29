@extends('layouts.app')

@section('title', 'Buat Pemesanan - Hotel Paradise')

@section('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 6rem auto 4rem;
        padding: 0 5%;
    }

    .page-title {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-title h1 {
        font-size: 2.5rem;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .booking-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }

    .booking-form-section {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .section-title {
        font-size: 1.5rem;
        color: var(--secondary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-color);
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .booking-summary {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .room-preview {
        background: var(--light-bg);
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .room-preview img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .room-preview h3 {
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .room-type-tag {
        display: inline-block;
        background: var(--primary-color);
        color: var(--secondary-color);
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.8rem 0;
        border-bottom: 1px solid #eee;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-label {
        color: var(--accent-color);
    }

    .summary-value {
        font-weight: 600;
        color: var(--text-color);
    }

    .summary-total {
        background: var(--primary-color);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
        color: var(--secondary-color);
    }

    .summary-total .summary-label {
        color: var(--secondary-color);
        font-size: 1.1rem;
    }

    .summary-total .summary-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--secondary-color);
    }

    @media (max-width: 968px) {
        .booking-container {
            grid-template-columns: 1fr;
        }

        .booking-summary {
            position: static;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $authedUser = auth()->user();
@endphp
<div class="container">
    <div class="page-title">
        <h1><i class="fas fa-calendar-check"></i> Buat Pemesanan</h1>
        <p style="color: var(--accent-color);">Lengkapi data Anda untuk melanjutkan pemesanan</p>
    </div>

    @if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Terjadi kesalahan!</strong>
            <ul style="margin-top: 0.5rem; list-style: inside;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
        @csrf
        
        <div class="booking-container">
            <!-- Left Column: Form -->
            <div>
                <!-- Room Selection -->
                <div class="booking-form-section">
                    <h2 class="section-title">
                        <i class="fas fa-bed"></i> Pilih Kamar
                    </h2>
                    
                    @if($room)
                        <input type="hidden" name="room_id" value="{{ $room->id }}" id="roomId">
                        <div style="background: var(--light-bg); padding: 1rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span class="room-type-tag">{{ $room->type }}</span>
                                <h3 style="margin-top: 0.5rem; color: var(--secondary-color);">Kamar {{ $room->number }}</h3>
                                <p style="color: var(--accent-color);">Rp {{ number_format($room->price, 0, ',', '.') }} /malam</p>
                            </div>
                            <a href="{{ route('rooms.index') }}" class="btn-secondary">Ganti</a>
                        </div>
                    @else
                        <p style="color: var(--accent-color); margin-bottom: 1rem;">Silakan pilih kamar terlebih dahulu</p>
                        <a href="{{ route('rooms.index') }}" class="btn-primary">Pilih Kamar</a>
                    @endif
                </div>

                <!-- Date Selection -->
                <div class="booking-form-section" style="margin-top: 2rem;">
                    <h2 class="section-title">
                        <i class="fas fa-calendar"></i> Tanggal Menginap
                    </h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="check_in">Check-in <span style="color: red;">*</span></label>
                            <input type="date" id="check_in" name="check_in" required min="{{ date('Y-m-d') }}" value="{{ $checkIn }}">
                        </div>
                        <div class="form-group">
                            <label for="check_out">Check-out <span style="color: red;">*</span></label>
                            <input type="date" id="check_out" name="check_out" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ $checkOut }}">
                        </div>
                    </div>
                </div>

                <!-- Guest Information -->
                <div class="booking-form-section" style="margin-top: 2rem;">
                    <h2 class="section-title">
                        <i class="fas fa-user"></i> Informasi Tamu
                    </h2>

                    @if($authedUser)
                    @endif
                        <div class="alert alert-success" style="margin-bottom: 1rem;">
                            <i class="fas fa-id-card"></i> Data tamu otomatis diambil dari profil. Ubah di halaman Profil jika perlu.
                        </div>
                    <div class="form-group">
                        <label for="notes">Catatan Tambahan</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="Permintaan khusus atau catatan untuk hotel (opsional)">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="booking-summary">
                <h2 class="section-title">
                    <i class="fas fa-receipt"></i> Ringkasan Pesanan
                </h2>

                @if($room)
                <div class="room-preview">
                    <img src="{{ $room->image_url }}" alt="{{ $room->type }}" onerror="this.src='https://images.unsplash.com/photo-1505691938895-1758d7feb511?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
                    <span class="room-type-tag">{{ $room->type }}</span>
                    <h3>Kamar {{ $room->number }}</h3>
                    <p style="color: var(--accent-color); margin-top: 0.5rem;">
                        <i class="fas fa-users"></i> {{ $room->capacity }} Tamu
                    </p>
                </div>

                <div id="summaryDetails">
                    <div class="summary-row">
                        <span class="summary-label">Check-in:</span>
                        <span class="summary-value" id="displayCheckIn">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Check-out:</span>
                        <span class="summary-value" id="displayCheckOut">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Jumlah Malam:</span>
                        <span class="summary-value" id="displayNights">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Harga per Malam:</span>
                        <span class="summary-value">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-total">
                        <div class="summary-row" style="border: none;">
                            <span class="summary-label">Total Pembayaran:</span>
                            <span class="summary-value" id="displayTotal">Rp 0</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1.5rem; padding: 1rem; font-size: 1.1rem;">
                    <i class="fas fa-check-circle"></i> Konfirmasi Pemesanan
                </button>

                <p style="text-align: center; color: var(--accent-color); font-size: 0.9rem; margin-top: 1rem;">
                    <i class="fas fa-shield-alt"></i> Pembayaran aman dan terenkripsi
                </p>
                @else
                <p style="text-align: center; color: var(--accent-color);">Pilih kamar terlebih dahulu</p>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
@if($room)
<script>
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const displayCheckIn = document.getElementById('displayCheckIn');
    const displayCheckOut = document.getElementById('displayCheckOut');
    const displayNights = document.getElementById('displayNights');
    const displayTotal = document.getElementById('displayTotal');
    const pricePerNight = {{ $room->price }};

    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    function updateSummary() {
        if (checkInInput.value) {
            displayCheckIn.textContent = formatDate(checkInInput.value);
        }
        
        if (checkOutInput.value) {
            displayCheckOut.textContent = formatDate(checkOutInput.value);
        }
        
        if (checkInInput.value && checkOutInput.value) {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            
            if (nights > 0) {
                displayNights.textContent = nights + ' malam';
                const total = nights * pricePerNight;
                displayTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        }
    }

    checkInInput.addEventListener('change', function() {
        const checkInDate = new Date(this.value);
        checkInDate.setDate(checkInDate.getDate() + 1);
        const minCheckOut = checkInDate.toISOString().split('T')[0];
        checkOutInput.min = minCheckOut;
        
        if (checkOutInput.value && checkOutInput.value < minCheckOut) {
            checkOutInput.value = minCheckOut;
        }
        updateSummary();
    });

    checkOutInput.addEventListener('change', updateSummary);

    // Initial update
    updateSummary();
</script>
@endif
@endsection
