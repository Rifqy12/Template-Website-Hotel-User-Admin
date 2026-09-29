<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hotel Paradise - Luxury Stay Experience')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #D4AF37;
            --secondary-color: #1a1a1a;
            --accent-color: #8B7355;
            --text-color: #333;
            --light-bg: #f8f8f8;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        /* Header & Navigation */
        .header {
            background: var(--white);
            box-shadow: var(--shadow);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            box-shadow: var(--shadow-lg);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            font-size: 2.5rem;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-menu a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--primary-color);
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--secondary-color);
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary-color);
            padding: 0.8rem 2rem;
            border: 2px solid var(--primary-color);
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 4px;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background: var(--text-color);
            transition: all 0.3s ease;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        /* Admin Shell */
        .admin-shell {
            min-height: 100vh;
            display: flex;
            background: var(--light-bg);
        }

        .admin-sidebar {
            width: 260px;
            background: var(--secondary-color);
            color: var(--white);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 1.25rem 1rem;
            overflow-y: auto;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            color: var(--white);
            text-decoration: none;
            border-radius: 10px;
        }

        .admin-brand:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .admin-brand i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .admin-brand strong {
            font-family: 'Playfair Display', serif;
            letter-spacing: 0.2px;
        }

        .admin-role {
            margin-left: auto;
            background: var(--primary-color);
            color: var(--secondary-color);
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .admin-nav {
            list-style: none;
            margin-top: 1.25rem;
            display: grid;
            gap: 0.25rem;
        }

        .admin-nav a,
        .admin-nav button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0.85rem;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.92);
            text-decoration: none;
            background: transparent;
            border: none;
            cursor: pointer;
            font: inherit;
            text-align: left;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .admin-nav a i,
        .admin-nav button i {
            width: 20px;
            text-align: center;
            color: var(--primary-color);
        }

        .admin-nav a:hover,
        .admin-nav button:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .admin-nav a.active {
            background: rgba(212, 175, 55, 0.18);
            color: var(--white);
        }

        .admin-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 0.9rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .admin-topbar .admin-identity {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--secondary-color);
            font-weight: 600;
        }

        .admin-topbar .admin-identity i {
            color: var(--primary-color);
        }

        .admin-main {
            padding: 1.25rem;
            flex: 1;
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                position: static;
                width: 100%;
                border-radius: 0;
            }
            .admin-content {
                margin-left: 0;
                width: 100%;
            }
            .admin-shell {
                flex-direction: column;
            }
        }

        /* Footer */
        .footer {
            background: var(--secondary-color);
            color: var(--white);
            padding: 4rem 5%;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-section h3 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .footer-section p,
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--white);
            transform: translateY(-3px);
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 2rem auto 0;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: #ccc;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }

            .nav-menu {
                position: fixed;
                top: 80px;
                right: -100%;
                width: 80%;
                max-width: 300px;
                height: calc(100vh - 80px);
                background: var(--white);
                flex-direction: column;
                align-items: flex-start;
                padding: 2rem;
                box-shadow: var(--shadow-lg);
                transition: right 0.3s ease;
            }

            .nav-menu.active {
                right: 0;
            }

            .navbar {
                padding: 1rem 3%;
            }

            .logo {
                font-size: 1.5rem;
            }
        }

        /* Loading Spinner */
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 2rem auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- Real-time Updates Script -->
    <script src="{{ asset('js/realtime-updates.js') }}" defer></script>

    @yield('styles')
</head>
<body>
    @php
        $isAdminLayout = auth()->check() && auth()->user()->role === 'admin';
    @endphp

    @if($isAdminLayout)
        <div class="admin-shell">
            <aside class="admin-sidebar">
                <a href="{{ route('home') }}" class="admin-brand">
                    <i class="fas fa-hotel"></i>
                    <strong>Hotel Paradise</strong>
                    <span class="admin-role">ADMIN</span>
                </a>

                <ul class="admin-nav">
                    <li>
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="fas fa-gauge-high"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.index') || request()->routeIs('rooms.edit') || request()->routeIs('rooms.show') ? 'active' : '' }}">
                            <i class="fas fa-bed"></i>
                            Kelola Kamar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.index') || request()->routeIs('bookings.show') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i>
                            Kelola Booking
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                            <i class="fas fa-inbox"></i>
                            Pesan Customer
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ratings.index') }}" class="{{ request()->routeIs('admin.ratings.*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i>
                            Rating Hotel
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit">
                                <i class="fas fa-right-from-bracket"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>

            <div class="admin-content">
                <div class="admin-topbar">
                    <div class="admin-identity">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                </div>

                <main class="admin-main">
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <!-- Header -->
        <header class="header" id="header">
            <nav class="navbar">
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-hotel"></i>
                    <span>Hotel Paradise</span>
                </a>
                
                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> Home</a></li>
                    @if(auth()->check() && auth()->user()->role === 'guest')
                    <li><a href="{{ route('bookings.history') }}" class="{{ request()->routeIs('bookings.history') || request()->routeIs('bookings.my-bookings') ? 'active' : '' }}"><i class="fas fa-history"></i> Riwayat</a></li>
                    @endif
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}"><i class="fas fa-info-circle"></i> Tentang</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><i class="fas fa-envelope"></i> Kontak</a></li>
                    <li style="display: flex; align-items: center; gap: 1.5rem;">
                        @if(auth()->check())
                            <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; gap: 0.5rem; color: var(--primary-color); font-weight: 600; text-decoration: none;">
                                <i class="fas fa-user-circle"></i>
                                {{ auth()->user()->name }}
                                @if(auth()->user()->role === 'admin')
                                <span style="background: var(--primary-color); color: var(--secondary-color); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem;">ADMIN</span>
                                @endif
                            </a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: var(--primary-color); cursor: pointer; font-weight: 600; text-decoration: underline;">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Login</a>
                            <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
                        @endif
                    </li>
                </ul>
                
                <div class="menu-toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Hotel Paradise</h3>
                    <p>Pengalaman menginap mewah dengan pelayanan terbaik dan fasilitas lengkap untuk kenyamanan Anda.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('rooms.index') }}">Kamar</a>
                    <a href="{{ route('bookings.index') }}">Booking</a>
                    <a href="{{ route('about') }}">Tentang Kami</a>
                    <a href="{{ route('contact') }}">Kontak</a>
                </div>
                
                <div class="footer-section">
                    <h3>Kontak</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Pantai Bali No. 70, Bali</p>
                    <p><i class="fas fa-phone"></i> +62 707 555333</p>
                    <p><i class="fas fa-envelope"></i> info@hotelparadise.com</p>
                    <p><i class="fas fa-clock"></i> 24/7 Customer Service</p>
                </div>
                
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p>Dapatkan penawaran spesial dan update terbaru dari kami.</p>
                    <form style="margin-top: 1rem;">
                        <input type="email" placeholder="Email Anda" style="padding: 0.8rem; border: none; border-radius: 5px; width: 100%; margin-bottom: 0.5rem;">
                        <button type="submit" class="btn-primary" style="width: 100%;">Subscribe</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Hotel Paradise. All Rights Reserved. | Designed with <i class="fas fa-heart" style="color: var(--primary-color);"></i></p>
            </div>
        </footer>
    @endif

    <script>
        // Mobile menu toggle (customer/guest layout only)
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!menuToggle.contains(e.target) && !navMenu.contains(e.target)) {
                    navMenu.classList.remove('active');
                }
            });
        }

        // Header scroll effect (customer/guest layout only)
        const header = document.getElementById('header');
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
