@extends('layouts.app')

@section('title', 'Kamar Kami - Hotel Paradise')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                    url('https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
        height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        text-align: center;
    }

    .page-header h1 {
        font-size: 3.5rem;
        color: var(--white);
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 4rem 5%;
    }

    .filters {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
        margin-bottom: 3rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .form-group input,
    .form-group select {
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .rooms-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
    }

    .room-card {
        background: var(--white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .room-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .room-image {
        width: 100%;
        height: 280px;
        object-fit: cover;
        position: relative;
    }

    .room-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--white);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status-available {
        color: #28a745;
    }

    .status-booked {
        color: #dc3545;
    }

    .room-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .room-type {
        display: inline-block;
        background: var(--primary-color);
        color: var(--secondary-color);
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1rem;
        align-self: flex-start;
    }

    .room-number {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        color: var(--secondary-color);
    }

    .room-description {
        color: var(--text-color);
        margin-bottom: 1.5rem;
        line-height: 1.6;
        flex-grow: 1;
    }

    .room-amenities {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .amenity {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--accent-color);
        font-size: 0.9rem;
    }

    .amenity i {
        color: var(--primary-color);
    }

    .room-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .room-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .price-label {
        display: block;
        font-size: 0.9rem;
        color: var(--accent-color);
        font-weight: 400;
    }

    .no-rooms {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--light-bg);
        border-radius: 15px;
    }

    .no-rooms i {
        font-size: 4rem;
        color: var(--accent-color);
        margin-bottom: 1rem;
    }

    .no-rooms h3 {
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .rooms-container {
            grid-template-columns: 1fr;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php $isAdmin = $isAdmin ?? false; @endphp
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1>{{ $isAdmin ? 'Kelola Kamar' : 'Kamar Kami' }}</h1>
        <p style="font-size: 1.2rem; margin-top: 1rem;">
            {{ $isAdmin ? 'Edit informasi kamar dan fasilitas' : 'Pilih kamar impian Anda' }}
        </p>
    </div>
</div>

<div class="container">
    @if($isAdmin)
        <div style="display:flex; justify-content:flex-end; margin-bottom: 1.5rem;">
            <a href="{{ route('rooms.create') }}" class="btn-primary" style="padding: 0.8rem 1.25rem;">
                <i class="fas fa-plus"></i> Tambah Kamar
            </a>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem; padding: 1rem 1.25rem; border-radius: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @unless($isAdmin)
    <!-- Filters -->
    <div class="filters">
        <form action="{{ route('rooms.check-availability') }}" method="POST" class="filter-form" id="filterForm">
            @csrf
            <div class="form-group">
                <label for="check_in">Check-in</label>
                <input type="date" id="check_in" name="check_in" min="{{ date('Y-m-d') }}" value="{{ request('check_in') }}">
            </div>
            
            <div class="form-group">
                <label for="check_out">Check-out</label>
                <input type="date" id="check_out" name="check_out" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ request('check_out') }}">
            </div>
            
            <div class="form-group">
                <label for="room_type">Tipe Kamar</label>
                <select id="room_type" name="room_type">
                    <option value="">Semua Tipe</option>
                    <option value="Standard" {{ request('room_type') == 'Standard' ? 'selected' : '' }}>Standard</option>
                    <option value="Deluxe" {{ request('room_type') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                    <option value="Suite" {{ request('room_type') == 'Suite' ? 'selected' : '' }}>Suite</option>
                    <option value="Family" {{ request('room_type') == 'Family' ? 'selected' : '' }}>Family</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn-primary" style="width: 100%; padding: 0.8rem;">
                    <i class="fas fa-search"></i> Cari Kamar
                </button>
            </div>
        </form>
    </div>
    @endunless

    <!-- Rooms Grid -->
    @if($rooms->count() > 0)
    <div class="rooms-container">
        @foreach($rooms as $room)
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
        <div class="room-card">
            <div style="position: relative;">
                 <img src="{{ $room->image_url }}" onerror="this.src='https://images.unsplash.com/photo-1505691938895-1758d7feb511?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'" 
                     alt="Kamar {{ $room->number }}" 
                     class="room-image">
                <span class="room-status status-{{ $isAvailable ? 'available' : 'booked' }}">
                    {{ $statusLabel }}
                </span>
            </div>
            
            <div class="room-content">
                <span class="room-type">{{ $room->type }}</span>
                <h3 class="room-number">Kamar {{ $room->number }}</h3>
                <p class="room-description">{{ $room->description }}</p>
                
                @php
                    $amenitiesList = $room->amenities ? array_filter(array_map('trim', explode(',', $room->amenities))) : [];
                @endphp
                <div class="room-amenities">
                    <div class="amenity">
                        <i class="fas fa-building"></i>
                        <span>Lantai {{ (int)substr((string)$room->number, 0, 1) }}</span>
                    </div>
                    <div class="amenity">
                        <i class="fas fa-users"></i>
                        <span>{{ $room->capacity }} Tamu</span>
                    </div>
                    @forelse($amenitiesList as $amenity)
                        <div class="amenity">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $amenity }}</span>
                        </div>
                    @empty
                        <div class="amenity">
                            <i class="fas fa-info-circle"></i>
                            <span>Fasilitas belum diisi</span>
                        </div>
                    @endforelse
                </div>
                
                <div class="room-footer">
                    <div>
                        <span class="price-label">Mulai dari</span>
                        <div class="room-price">Rp {{ number_format($room->price, 0, ',', '.') }}</div>
                        <span class="price-label">/malam</span>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="{{ route('rooms.show', $room->id) }}" class="btn-secondary" style="padding: 0.6rem 1.5rem;">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        @if(!$isAdmin && $isAvailable)
                        <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}" class="btn-primary" style="padding: 0.6rem 1.5rem;">
                            <i class="fas fa-calendar-check"></i> Pesan
                        </a>
                        @endif
                        @if($isAdmin)
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn-primary" style="padding: 0.6rem 1.5rem; background: #1a1a1a; color: #fff;">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="no-rooms">
        <i class="fas fa-bed"></i>
        <h3>{{ $isAdmin ? 'Belum ada data kamar' : 'Tidak ada kamar tersedia' }}</h3>
        <p>{{ $isAdmin ? 'Silakan tambah atau edit data kamar.' : 'Silakan coba tanggal atau tipe kamar lainnya' }}</p>
    </div>
    @endif
</div>
@endsection

@section('scripts')
@unless($isAdmin)
<script>
    // Date validation
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            checkInDate.setDate(checkInDate.getDate() + 1);
            const minCheckOut = checkInDate.toISOString().split('T')[0];
            checkOutInput.min = minCheckOut;
            
            if (checkOutInput.value && checkOutInput.value < minCheckOut) {
                checkOutInput.value = minCheckOut;
            }
        });
    }
</script>
@endunless
@endsection
