@extends('layouts.app')

@section('title', 'Edit Kamar')

@section('content')
<style>
    .edit-container { max-width: 720px; margin: 6rem auto 4rem; padding: 0 1.5rem; }
    .card { background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 2rem; }
    .card h1 { font-size: 1.8rem; margin-bottom: 1.5rem; color: var(--secondary-color); display: flex; gap: 0.6rem; align-items: center; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 0.4rem; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.85rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: 1rem; }
    .form-group textarea { min-height: 120px; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(212,175,55,0.15); }
    .actions { display: flex; gap: 1rem; margin-top: 1rem; }
    .btn-primary { padding: 0.9rem 1.2rem; border: none; border-radius: 10px; background: var(--primary-color); color: var(--secondary-color); font-weight: 700; cursor: pointer; }
    .btn-secondary { padding: 0.9rem 1.2rem; border: 1px solid #ddd; border-radius: 10px; background: #fff; color: var(--text-color); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
    .alert { padding: 0.9rem 1rem; border-radius: 10px; margin-bottom: 1rem; }
    .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecdd3; }
</style>

<div class="edit-container">
    <div class="card">
        <h1><i class="fas fa-pen"></i> Edit Kamar</h1>

        @if($errors->any())
            <div class="alert alert-error">
                <strong>Periksa inputan:</strong>
                <ul style="margin-top: 0.5rem; padding-left: 1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.update', $room->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="number">Nama/No Kamar</label>
                <input type="text" id="number" name="number" value="{{ old('number', $room->number) }}" required>
            </div>
            <div class="form-group">
                <label for="type">Tipe Kamar</label>
                <input type="text" id="type" name="type" value="{{ old('type', $room->type) }}" required>
            </div>
            <div class="form-group">
                <label>Lantai (otomatis dari nomor kamar)</label>
                <input type="text" value="Lantai {{ (int)substr((string)old('number', $room->number), 0, 1) }}" disabled>
                <small style="display:block; margin-top: 0.35rem; color: var(--accent-color);">
                    Format nomor kamar: 3 digit. Angka pertama = lantai, 2 angka terakhir = nomor kamar.
                </small>
            </div>
            <div class="form-group">
                <label for="price">Harga per Malam</label>
                <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $room->price) }}" required>
            </div>
            <div class="form-group">
                <label for="capacity">Kapasitas (jumlah tamu)</label>
                <input type="number" id="capacity" name="capacity" min="1" value="{{ old('capacity', $room->capacity) }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ old('status', $room->status) === 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" placeholder="Deskripsi singkat kamar">{{ old('description', $room->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="amenities">Fasilitas (pisahkan dengan koma)</label>
                <textarea id="amenities" name="amenities" placeholder="WiFi, AC, TV, Bathub">{{ old('amenities', $room->amenities) }}</textarea>
            </div>

            <div class="actions">
                <button
                    type="button"
                    class="btn-secondary"
                    onclick="document.getElementById('status').value='available'; this.closest('form').submit();"
                >Jadikan Tersedia</button>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="{{ route('rooms.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
