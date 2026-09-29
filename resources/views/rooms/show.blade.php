@extends('layouts.app')

@section('title', 'Detail Kamar - Hotel Paradise')

@section('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 6rem auto 4rem;
        padding: 0 5%;
    }

    .room-detail {
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .room-gallery {
        height: 500px;
        position: relative;
        background-size: cover;
        background-position: center;
    }

    .room-status-badge {
        position: absolute;
        top: 2rem;
        right: 2rem;
        background: var(--white);
        padding: 0.8rem 1.5rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1rem;
    }

    .status-available {
        color: #28a745;
    }

    .room-info {
        padding: 3rem;
    }

    .room-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .room-type-badge {
        background: var(--primary-color);
        color: var(--secondary-color);
        padding: 0.5rem 1.5rem;
        border-radius: 30px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .room-title {
        font-size: 2.5rem;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .room-price-lg {
        text-align: right;
    }

    .price-amount {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .price-label {
        color: var(--accent-color);
        font-size: 1rem;
    }

    .room-description {
        color: var(--text-color);
        line-height: 1.8;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    .amenities-section {
        background: var(--light-bg);
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }

    .amenities-section h3 {
        color: var(--secondary-color);
        margin-bottom: 1.5rem;
    }

    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .amenity-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.8rem;
        background: var(--white);
        border-radius: 8px;
    }

    .amenity-item i {
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    .booking-section {
        background: var(--primary-color);
        padding: 2rem;
        border-radius: 15px;
        color: var(--secondary-color);
    }

    .booking-section h3 {
        margin-bottom: 1.5rem;
    }

    .booking-form {
        display: grid;
        gap: 1.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        padding: 0.8rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
    }

    .booking-summary {
        background: rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .summary-total {
        font-size: 1.5rem;
        font-weight: 700;
        border-top: 2px solid rgba(0, 0, 0, 0.2);
        padding-top: 1rem;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .room-gallery {
            height: 300px;
        }

        .room-info {
            padding: 2rem;
        }

        .room-title {
            font-size: 2rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .amenities-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php $isAdmin = $isAdmin ?? false; @endphp
@php
    $hasActiveBooking = (bool)($room->has_active_booking ?? false);
    $isAvailable = $room->status === 'available' && !$hasActiveBooking;

    $statusLabel = 'Tersedia';
    if ($room->status === 'maintenance') {
        $statusLabel = 'Maintenance';
    } elseif ($room->status !== 'available' || $hasActiveBooking) {
        $statusLabel = 'Dipesan';
    }
@endphp
<div class="container">
    <div class="room-detail">
    <!-- Room Gallery -->
        <div class="room-gallery" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('{{ $room->image_url }}');">
            <span class="room-status-badge status-{{ $isAvailable ? 'available' : 'booked' }}">
                <i class="fas fa-{{ $isAvailable ? 'check-circle' : 'times-circle' }}"></i>
                {{ $statusLabel }}
            </span>
        </div>

        <!-- Room Info -->
        <div class="room-info">
            <div class="room-header">
                <div>
                    <span class="room-type-badge">{{ $room->type }}</span>
                    <h1 class="room-title">Kamar {{ $room->number }}</h1>
                    <p style="color: var(--accent-color); display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-users"></i> Kapasitas: {{ $room->capacity }} Tamu
                    </p>
                    <p style="color: var(--accent-color); display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                        <i class="fas fa-building"></i> Lantai: {{ (int)substr((string)$room->number, 0, 1) }}
                    </p>
                </div>
                <div class="room-price-lg">
                    <div class="price-amount">Rp {{ number_format($room->price, 0, ',', '.') }}</div>
                    <div class="price-label">per malam</div>
                </div>
            </div>

            <p class="room-description">{{ $room->description }}</p>

            <!-- Amenities -->
            <div class="amenities-section">
                <h3><i class="fas fa-star"></i> Fasilitas Kamar</h3>
                @php
                    $amenitiesList = $room->amenities ? array_filter(array_map('trim', explode(',', $room->amenities))) : [];
                @endphp
                <div class="amenities-grid">
                    @forelse($amenitiesList as $amenity)
                        <div class="amenity-item">
                            <i class="fas fa-check"></i>
                            <span>{{ $amenity }}</span>
                        </div>
                    @empty
                        <div class="amenity-item">
                            <i class="fas fa-info-circle"></i>
                            <span>Fasilitas belum diisi</span>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($isAdmin)
                <div class="booking-section" style="background: #1a1a1a; color: #fff;">
                    <h3><i class="fas fa-tools"></i> Mode Admin</h3>
                    <p>Gunakan halaman ini untuk meninjau detail kamar. Pemesanan dinonaktifkan untuk admin.</p>
                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn-primary" style="background: #fff; color: #1a1a1a; font-weight: 700; margin-top: 1rem;">Edit Kamar</a>
                </div>
            @else
                <!-- Booking Form -->
                @if($isAvailable)
                <div class="booking-section">
                    <h3><i class="fas fa-calendar-check"></i> Pesan Kamar Ini</h3>
                    <form action="{{ route('bookings.create') }}" method="GET" class="booking-form" id="bookingForm">
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="check_in">Check-in</label>
                                <input type="date" id="check_in" name="check_in" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="form-group">
                                <label for="check_out">Check-out</label>
                                <input type="date" id="check_out" name="check_out" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                        </div>

                        <div class="booking-summary" id="bookingSummary" style="display: none;">
                            <div class="summary-row">
                                <span>Harga per malam:</span>
                                <span>Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Jumlah malam:</span>
                                <span id="nightsCount">-</span>
                            </div>
                            <div class="summary-row summary-total">
                                <span>Total:</span>
                                <span id="totalPrice">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; background: var(--secondary-color); color: var(--primary-color);">
                            <i class="fas fa-calendar-check"></i> Lanjutkan Pemesanan
                        </button>
                    </form>
                </div>
                @else
                <div class="booking-section" style="background: #f8d7da; color: #721c24;">
                    <h3><i class="fas fa-exclamation-circle"></i> Kamar Tidak Tersedia</h3>
                    <p>Maaf, kamar ini sedang tidak tersedia. Silakan pilih kamar lain atau hubungi kami untuk informasi lebih lanjut.</p>
                    <a href="{{ route('rooms.index') }}" class="btn-primary" style="background: #721c24; color: white; margin-top: 1rem;">
                        Lihat Kamar Lainnya
                    </a>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const bookingSummary = document.getElementById('bookingSummary');
    const nightsCount = document.getElementById('nightsCount');
    const totalPrice = document.getElementById('totalPrice');
    const pricePerNight = parseFloat('{{ $room->price }}');

    function calculateTotal() {
        if (checkInInput.value && checkOutInput.value) {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            
            if (nights > 0) {
                const total = nights * pricePerNight;
                nightsCount.textContent = nights + ' malam';
                totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
                bookingSummary.style.display = 'block';
            } else {
                bookingSummary.style.display = 'none';
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
        calculateTotal();
    });

    checkOutInput.addEventListener('change', calculateTotal);
</script>
@endsection
