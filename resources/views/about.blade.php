@extends('layouts.app')

@section('title', 'Tentang Kami - Hotel Paradise')

@section('styles')
<style>
    .hero-about {
        height: 60vh;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                    url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        text-align: center;
    }

    .hero-about h1 {
        font-size: 3.5rem;
        color: var(--white);
        margin-bottom: 1rem;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 5%;
    }

    .about-section {
        margin-bottom: 5rem;
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

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: center;
    }

    .about-content p {
        line-height: 1.8;
        color: var(--text-color);
        margin-bottom: 1rem;
        font-size: 1.05rem;
    }

    .about-image {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .about-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .rating-card {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
        text-align: center;
    }

    .stars {
        display: inline-flex;
        flex-direction: row-reverse;
        gap: 0.3rem;
        align-items: center;
        justify-content: center;
    }

    .stars input {
        display: none;
    }

    .stars label {
        cursor: pointer;
        font-size: 1.6rem;
        color: #ddd;
        transition: transform 0.1s ease;
    }

    .stars label:hover {
        transform: translateY(-1px);
    }

    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label {
        color: var(--primary-color);
    }

    .value-card {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
        text-align: center;
        transition: all 0.3s ease;
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .value-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--secondary-color);
    }

    .value-card h3 {
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .value-card p {
        color: var(--text-color);
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .hero-about h1 {
            font-size: 2rem;
        }

        .about-grid {
            grid-template-columns: 1fr;
        }

        .values-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero -->
<div class="hero-about">
    <div>
        <h1>Tentang Hotel Paradise</h1>
        <p style="font-size: 1.2rem;">Pengalaman menginap yang tak terlupakan sejak 2010</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1.25rem; padding: 1rem 1.25rem; border-radius: 10px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert" style="margin-bottom: 1.25rem; padding: 1rem 1.25rem; border-radius: 10px; background: #fef2f2; color: #991b1b; border: 1px solid #fecdd3;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Our Story -->
    <div class="about-section">
        <div class="about-grid">
            <div class="about-content">
                <h2 style="color: var(--secondary-color); margin-bottom: 1.5rem; font-size: 2rem;">Kisah Kami</h2>
                <p>Hotel Paradise didirikan pada tahun 2010 dengan visi untuk menyediakan pengalaman menginap yang tak terlupakan bagi setiap tamu. Berlokasi di tepi pantai yang indah, kami menawarkan pemandangan laut yang menakjubkan dan suasana yang tenang.</p>
                <p>Dengan 15 kamar yang dirancang dengan elegan, kami menggabungkan kemewahan modern dengan sentuhan tradisional lokal. Setiap detail dirancang untuk memberikan kenyamanan maksimal bagi tamu kami.</p>
                <p>Tim kami yang berpengalaman dan ramah siap melayani Anda 24/7, memastikan setiap kebutuhan Anda terpenuhi dengan sempurna.</p>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hotel Paradise">
            </div>
        </div>
    </div>

    <!-- Rating -->
    @php
        $avg = (float)($ratingStats['avg'] ?? 0);
        $count = (int)($ratingStats['count'] ?? 0);
        $avgText = $count > 0 ? number_format($avg, 1) : '0.0';
        $avgStars = (int) round($avg);
        $my = (int) ($myRating ?? 0);
    @endphp
    <div class="about-section">
        <div class="section-title">
            <h2>Rating Hotel</h2>
            <p>Penilaian dari customer yang pernah menginap</p>
        </div>

        <div class="rating-card">
            <div style="font-size: 2.4rem; font-weight: 800; color: var(--secondary-color); line-height: 1;">
                {{ $avgText }}<span style="font-size: 1.1rem; font-weight: 600; color: var(--accent-color);">/5</span>
            </div>
            <div style="margin-top: 0.6rem;">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star" style="color: {{ $i <= $avgStars ? 'var(--primary-color)' : '#ddd' }};"></i>
                @endfor
            </div>
            <div style="margin-top: 0.6rem; color: var(--accent-color);">
                {{ number_format($count) }} rating
            </div>

            <div style="margin-top: 1.25rem; border-top: 1px solid #eee; padding-top: 1.25rem;">
                @if(auth()->check() && auth()->user()->role === 'guest')
                    <div style="color: var(--secondary-color); font-weight: 700; margin-bottom: 0.5rem;">
                        Beri rating kamu
                    </div>
                    <form method="POST" action="{{ route('about.rating') }}" style="display:flex; flex-direction: column; align-items:center; gap: 0.9rem;">
                        @csrf
                        <div class="stars" aria-label="Pilih rating 1 sampai 5">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', $my) == $i ? 'checked' : '' }}>
                                <label for="star{{ $i }}" title="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <div style="color: #991b1b; font-weight: 600;">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn-primary" style="padding: 0.9rem 1.2rem;">
                            Simpan Rating
                        </button>
                    </form>
                @else
                    <div style="color: var(--accent-color); margin-bottom: 0.8rem;">
                        Login sebagai customer untuk memberi rating.
                    </div>
                    <a href="{{ route('login') }}" class="btn-primary" style="padding: 0.9rem 1.2rem;">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Our Values -->
    <div class="about-section">
        <div class="section-title">
            <h2>Nilai-Nilai Kami</h2>
            <p>Prinsip yang menjadi landasan pelayanan kami</p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Keramahan</h3>
                <p>Kami menyambut setiap tamu dengan hangat dan tulus, menciptakan suasana seperti di rumah sendiri.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Kualitas</h3>
                <p>Komitmen kami untuk memberikan layanan dan fasilitas dengan standar tertinggi.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Keberlanjutan</h3>
                <p>Kami peduli terhadap lingkungan dan menerapkan praktik ramah lingkungan.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Komunitas</h3>
                <p>Kami aktif berkontribusi untuk pengembangan masyarakat lokal.</p>
            </div>
        </div>
    </div>

    <!-- Facilities -->
    <div class="about-section">
        <div class="section-title">
            <h2>Fasilitas Unggulan</h2>
            <p>Kenyamanan dan kemewahan untuk pengalaman terbaik</p>
        </div>

        <div class="about-grid">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fasilitas">
            </div>
            <div class="about-content">
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 1rem 0; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-swimming-pool" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                        <div>
                            <strong>Kolam Renang Infinity</strong>
                            <p style="margin: 0; color: var(--accent-color); font-size: 0.9rem;">Dengan pemandangan laut yang menakjubkan</p>
                        </div>
                    </li>
                    <li style="padding: 1rem 0; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-utensils" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                        <div>
                            <strong>Restaurant & Bar</strong>
                            <p style="margin: 0; color: var(--accent-color); font-size: 0.9rem;">Hidangan lokal dan internasional</p>
                        </div>
                    </li>
                    <li style="padding: 1rem 0; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-spa" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                        <div>
                            <strong>Spa & Wellness Center</strong>
                            <p style="margin: 0; color: var(--accent-color); font-size: 0.9rem;">Relaksasi total untuk tubuh dan pikiran</p>
                        </div>
                    </li>
                    <li style="padding: 1rem 0; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-dumbbell" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                        <div>
                            <strong>Fitness Center</strong>
                            <p style="margin: 0; color: var(--accent-color); font-size: 0.9rem;">Peralatan modern untuk kebugaran Anda</p>
                        </div>
                    </li>
                    <li style="padding: 1rem 0; display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-briefcase" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                        <div>
                            <strong>Meeting Rooms</strong>
                            <p style="margin: 0; color: var(--accent-color); font-size: 0.9rem;">Fasilitas lengkap untuk acara bisnis</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
