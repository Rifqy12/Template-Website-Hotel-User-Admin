@extends('layouts.app')

@section('title', 'Hubungi Kami - Hotel Paradise')

@section('styles')
<style>
    .hero-contact {
        height: 50vh;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                    url('https://images.unsplash.com/photo-1596436889106-be35e843f974?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        text-align: center;
    }

    .hero-contact h1 {
        font-size: 3.5rem;
        color: var(--white);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 5%;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-top: 3rem;
    }

    .contact-info {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .contact-info h2 {
        color: var(--secondary-color);
        margin-bottom: 2rem;
    }

    .info-item {
        display: flex;
        align-items: start;
        gap: 1.5rem;
        padding: 1.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.3rem;
        color: var(--secondary-color);
    }

    .info-content h3 {
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .info-content p {
        color: var(--text-color);
        margin: 0;
    }

    .contact-form {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .contact-form h2 {
        color: var(--secondary-color);
        margin-bottom: 2rem;
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

    .map-section {
        margin-top: 5rem;
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .map-section h2 {
        color: var(--secondary-color);
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .map-container {
        width: 100%;
        height: 400px;
        border-radius: 10px;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .hero-contact h1 {
            font-size: 2rem;
        }

        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero -->
<div class="hero-contact">
    <div>
        <h1>Hubungi Kami</h1>
        <p style="font-size: 1.2rem; margin-top: 1rem;">Kami siap membantu Anda 24/7</p>
    </div>
</div>

<div class="container">
    <div class="contact-grid">
        <!-- Contact Information -->
        <div class="contact-info">
            <h2><i class="fas fa-address-book"></i> Informasi Kontak</h2>
            
            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="info-content">
                    <h3>Alamat</h3>
                    <p>Jl. Pantai Indah No. 123<br>Seminyak, Bali 80361<br>Indonesia</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="info-content">
                    <h3>Telepon</h3>
                    <p>+62 707 555333</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="info-content">
                    <h3>Email</h3>
                    <p>info@hotelparadise.com<br>reservation@hotelparadise.com</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="info-content">
                    <h3>Jam Operasional</h3>
                    <p>Resepsionis: 24 Jam<br>Restaurant: 06:00 - 23:00 WIB<br>Spa: 09:00 - 21:00 WIB</p>
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <h3 style="color: var(--secondary-color); margin-bottom: 1rem;">Ikuti Kami</h3>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" style="width: 45px; height: 45px; background: var(--primary-color); color: var(--secondary-color); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" style="width: 45px; height: 45px; background: var(--primary-color); color: var(--secondary-color); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" style="width: 45px; height: 45px; background: var(--primary-color); color: var(--secondary-color); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" style="width: 45px; height: 45px; background: var(--primary-color); color: var(--secondary-color); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" style="width: 45px; height: 45px; background: var(--primary-color); color: var(--secondary-color); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form">
            <h2><i class="fas fa-paper-plane"></i> Kirim Pesan</h2>

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 1.25rem; padding: 1rem 1.25rem; border-radius: 10px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert" style="margin-bottom: 1.25rem; padding: 1rem 1.25rem; border-radius: 10px; background: #fef2f2; color: #991b1b; border: 1px solid #fecdd3;">
                    <strong>Periksa inputan:</strong>
                    <ul style="margin-top: 0.5rem; padding-left: 1.2rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com">
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx">
                </div>

                <div class="form-group">
                    <label for="subject">Subjek</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required placeholder="Subjek pesan">
                </div>

                <div class="form-group">
                    <label for="message">Pesan</label>
                    <textarea id="message" name="message" rows="6" required placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem;">
                    <i class="fas fa-paper-plane"></i> Kirim Pesan
                </button>
            </form>
        </div>
    </div>

    <!-- Map Section -->
    <div class="map-section">
        <h2><i class="fas fa-map"></i> Lokasi Kami</h2>
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.2076489283707!2d115.16088331478238!3d-8.688488093750928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2409b0e5e80db%3A0xe27334e8ccb9b6!2sSeminyak%2C%20Kuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1649849999999!5m2!1sen!2sid" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>
@endsection
