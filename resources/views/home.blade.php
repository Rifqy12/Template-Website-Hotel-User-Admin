@extends('layouts.app')

@section('title', 'Hotel Paradise - Luxury Stay Experience')

@section('styles')
<style>
    /* Hero Section */
    .hero {
        height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                    url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: var(--white);
        position: relative;
    }

    .hero-content {
        max-width: 900px;
        padding: 2rem;
        animation: fadeInUp 1s ease;
    }

    .hero h1 {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: var(--white);
    }

    .hero p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Booking Form Widget */
    .booking-widget {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow-lg);
        margin-top: 2rem;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .booking-form {
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
        color: var(--text-color);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .form-group input,
    .form-group select {
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    /* Features Section */
    .features {
        padding: 5rem 5%;
        background: var(--light-bg);
    }

    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title h2 {
        font-size: 2.5rem;
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .section-title p {
        color: var(--accent-color);
        font-size: 1.1rem;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .feature-card {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .feature-card i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .feature-card h3 {
        margin-bottom: 1rem;
        color: var(--secondary-color);
    }

    .feature-card p {
        color: var(--text-color);
        line-height: 1.8;
    }

    /* Rooms Section */
    .rooms {
        padding: 5rem 5%;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .room-card {
        background: var(--white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }

    .room-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .room-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .room-content {
        padding: 1.5rem;
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
    }

    .room-content h3 {
        margin-bottom: 0.5rem;
        color: var(--secondary-color);
    }

    .room-content p {
        color: var(--text-color);
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .room-features {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .room-features span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        color: var(--accent-color);
        font-size: 0.9rem;
    }

    .room-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .room-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .room-price span {
        font-size: 0.9rem;
        color: var(--accent-color);
        font-weight: 400;
    }

    /* CTA Section */
    .cta {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                    url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
        padding: 5rem 5%;
        text-align: center;
        color: var(--white);
    }

    .cta h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--white);
    }

    .cta p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1rem;
        }

        .booking-form {
            grid-template-columns: 1fr;
        }

        .rooms-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        @if($isAdmin)
            <h1>Halo Admin, kelola operasional hotel</h1>
            <p>Gunakan tautan di bawah untuk memonitor booking dan ketersediaan kamar.</p>
            <div class="hero-buttons">
                <a href="{{ route('bookings.index') }}" class="btn-primary">Kelola Booking</a>
                <a href="{{ route('rooms.index') }}" class="btn-secondary">Kelola Kamar</a>
            </div>
        @else
            <h1>Selamat Datang di Hotel Paradise</h1>
            <p>Rasakan pengalaman menginap yang tak terlupakan dengan kemewahan dan kenyamanan kelas dunia</p>
            <div class="hero-buttons">
                <a href="{{ route('bookings.create') }}" class="btn-primary">Pesan Sekarang</a>
                <a href="{{ route('rooms.index') }}" class="btn-secondary">Lihat Kamar</a>
            </div>
            
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="section-title">
        <h2>Mengapa Memilih Hotel Paradise?</h2>
        <p>Fasilitas dan pelayanan terbaik untuk kenyamanan Anda</p>
    </div>
    
    <div class="features-grid">
        <div class="feature-card">
            <i class="fas fa-wifi"></i>
            <h3>WiFi Gratis</h3>
            <p>Akses internet super cepat di seluruh area hotel untuk kemudahan Anda</p>
        </div>
        
        <div class="feature-card">
            <i class="fas fa-concierge-bell"></i>
            <h3>Layanan 24/7</h3>
            <p>Resepsionis dan room service siap melayani Anda kapan saja</p>
        </div>
        
        <div class="feature-card">
            <i class="fas fa-swimming-pool"></i>
            <h3>Kolam Renang</h3>
            <p>Kolam renang infinity dengan pemandangan laut yang menakjubkan</p>
        </div>
        
        <div class="feature-card">
            <i class="fas fa-utensils"></i>
            <h3>Restaurant & Bar</h3>
            <p>Nikmati hidangan lezat dari chef profesional kami</p>
        </div>
        
        <div class="feature-card">
            <i class="fas fa-spa"></i>
            <h3>Spa & Wellness</h3>
            <p>Relaksasi total dengan treatment spa berkelas internasional</p>
        </div>
        
        <div class="feature-card">
            <i class="fas fa-parking"></i>
            <h3>Parkir Gratis</h3>
            <p>Area parkir luas dan aman untuk kendaraan Anda</p>
        </div>
    </div>
</section>

<!-- Featured Rooms Section -->
<section class="rooms">
    <div class="section-title">
        <h2>Kamar Pilihan Kami</h2>
        <p>Pilih kamar yang sesuai dengan kebutuhan dan budget Anda</p>
    </div>
    
    <div class="rooms-grid">
        @foreach($featuredRooms as $room)
        <div class="room-card">
            <img src="{{ $room->image_url }}" alt="{{ $room->type }}" class="room-image" onerror="this.src='https://images.unsplash.com/photo-1505691938895-1758d7feb511?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
            <div class="room-content">
                <span class="room-type">{{ $room->type }}</span>
                <h3>Kamar {{ $room->number }}</h3>
                <p>{{ Str::limit($room->description, 100) }}</p>
                
                <div class="room-features">
                    <span><i class="fas fa-users"></i> {{ $room->capacity }} Tamu</span>
                    <span><i class="fas fa-bed"></i> King Bed</span>
                    <span><i class="fas fa-wifi"></i> WiFi</span>
                </div>
                
                <div class="room-footer">
                    <div class="room-price">
                        Rp {{ number_format($room->price, 0, ',', '.') }}
                        <span>/malam</span>
                    </div>
                    <a href="{{ route('rooms.show', $room->id) }}" class="btn-secondary">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ route('rooms.index') }}" class="btn-primary">Lihat Semua Kamar</a>
    </div>
</section>

@if(!$isAdmin)
<!-- CTA Section -->
<section class="cta">
    <h2>Siap Untuk Pengalaman Tak Terlupakan?</h2>
    <p>Pesan kamar Anda sekarang dan nikmati diskon khusus untuk pemesanan online</p>
    <a href="{{ route('bookings.create') }}" class="btn-primary" style="font-size: 1.2rem; padding: 1rem 3rem;">Pesan Sekarang</a>
</section>
@endif
@endsection

@section('scripts')
<script>
    // Set minimum date for check-out based on check-in
    const checkInInput = document.querySelector('input[name="check_in"]');
    const checkOutInput = document.querySelector('input[name="check_out"]');
    
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
@endsection
