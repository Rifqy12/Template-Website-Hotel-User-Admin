@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-container {
        max-width: 600px;
        margin: 6rem auto 4rem;
        padding: 0 1.5rem;
    }
    .profile-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 2rem;
    }
    .profile-card h1 {
        margin-bottom: 1.5rem;
        color: var(--secondary-color);
        font-size: 1.8rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display:block; font-weight:600; margin-bottom:0.35rem; color:#333; }
    .form-group input { width:100%; padding:0.85rem 1rem; border:1px solid #e5e7eb; border-radius:10px; font-size:1rem; }
    .form-group input:focus { outline:none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(212,175,55,0.15); }
    .help { color:#666; font-size:0.9rem; margin-top:0.25rem; }
    .btn-primary { width:100%; text-align:center; padding:0.9rem 1rem; border:none; border-radius:10px; background: var(--primary-color); color: var(--secondary-color); font-weight:700; font-size:1rem; cursor:pointer; transition: all 0.2s; }
    .btn-primary:hover { background:#c9a961; transform: translateY(-1px); }
    .alert { padding:0.9rem 1rem; border-radius:10px; margin-bottom:1rem; font-weight:600; }
    .alert-success { background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; }
    .alert-error { background:#fef2f2; color:#991b1b; border:1px solid #fecdd3; }
    .error-list { margin:0.35rem 0 0 1rem; }
</style>

<div class="profile-container">
    <div class="profile-card">
        <h1><i class="fas fa-user-cog"></i> Profil Saya</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                Terjadi kesalahan:
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" required>
            </div>

            <div class="form-group">
                <label for="id_number">No. Identitas (KTP/SIM/Paspor)</label>
                <input id="id_number" name="id_number" type="text" value="{{ old('id_number', $user->id_number) }}" required>
                <p class="help">Gunakan nomor identitas yang valid untuk check-in.</p>
            </div>

            <div class="form-group">
                <label for="address">Alamat Lengkap</label>
                <input id="address" name="address" type="text" value="{{ old('address', $user->address) }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password baru (opsional)</label>
                <input id="password" name="password" type="password" placeholder="Biarkan kosong jika tidak ganti">
                <p class="help">Minimal 6 karakter</p>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi password baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="btn-primary">Simpan Profil</button>
        </form>
    </div>
</div>
@endsection
