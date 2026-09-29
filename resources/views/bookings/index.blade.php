@extends('layouts.app')

@section('title', 'Daftar Pemesanan - Hotel Paradise')

@section('styles')
<style>
    .container {
        max-width: 1400px;
        margin: 6rem auto 4rem;
        padding: 0 5%;
    }

    .page-header {
        margin-bottom: 3rem;
    }

    .page-header h1 {
        font-size: 2.5rem;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .page-header p {
        color: var(--accent-color);
        font-size: 1.1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .stat-icon.pending {
        background: #fff3cd;
        color: #856404;
    }

    .stat-icon.confirmed {
        background: #d4edda;
        color: #155724;
    }

    .stat-icon.cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .stat-icon.total {
        background: #d1ecf1;
        color: #0c5460;
    }

    .stat-info h3 {
        color: var(--text-color);
        font-size: 2rem;
        margin-bottom: 0.2rem;
    }

    .stat-info p {
        color: var(--accent-color);
        font-size: 0.9rem;
    }

    .bookings-table {
        background: var(--white);
        border-radius: 15px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table-header {
        background: var(--primary-color);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h2 {
        color: var(--secondary-color);
        margin: 0;
    }

    .filter-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        border: none;
        background: rgba(0, 0, 0, 0.1);
        color: var(--secondary-color);
        border-radius: 20px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--secondary-color);
        color: var(--primary-color);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: var(--light-bg);
    }

    th {
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 600;
        color: var(--secondary-color);
        border-bottom: 2px solid #ddd;
    }

    td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #eee;
        color: var(--text-color);
    }

    /* Tighten the ID column so other fields fit better (desktop/table layout) */
    @media (min-width: 1201px) {
        .bookings-table table th:first-child,
        .bookings-table table td:first-child {
            width: 90px;
            padding-left: 0.9rem;
            padding-right: 0.75rem;
            white-space: nowrap;
        }

        .bookings-table table td:first-child strong {
            font-size: 0.9rem;
        }
    }

    tr:hover {
        background: var(--light-bg);
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-confirmed {
        background: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        padding: 0.5rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-view {
        background: #d1ecf1;
        color: #0c5460;
    }

    .btn-view:hover {
        background: #0c5460;
        color: white;
    }

    .btn-confirm {
        background: #d4edda;
        color: #155724;
    }

    .btn-confirm:hover {
        background: #155724;
        color: white;
    }

    .btn-cancel {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-cancel:hover {
        background: #721c24;
        color: white;
    }

    .no-bookings {
        text-align: center;
        padding: 4rem 2rem;
    }

    .no-bookings i {
        font-size: 4rem;
        color: var(--accent-color);
        margin-bottom: 1rem;
    }

    .real-time-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--secondary-color);
        font-size: 0.9rem;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background: #28a745;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.3;
        }
    }

    .pay-badge {
        display: inline-block;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    /* Show all fields without horizontal scrolling by stacking rows on smaller screens */
    @media (max-width: 1200px) {
        table {
            display: block;
        }

        thead {
            display: none;
        }

        tbody {
            display: block;
        }

        tr.booking-row {
            display: block;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: transparent;
        }

        td {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            padding: 0.75rem 1.25rem;
            border-bottom: none;
        }

        td::before {
            content: attr(data-label);
            color: var(--accent-color);
            font-weight: 700;
            flex: 0 0 120px;
        }

        .action-buttons {
            justify-content: flex-end;
        }
    }

    .pay-paid {
        background: #d4edda;
        color: #155724;
    }

    .pay-unpaid {
        background: #fff3cd;
        color: #856404;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            gap: 1rem;
        }

        .filter-buttons {
            flex-wrap: wrap;
        }

        th, td {
            padding: 1rem;
            white-space: normal;
        }

        td::before {
            flex-basis: 95px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-list"></i> Daftar Pemesanan</h1>
        <p>Kelola dan monitor semua pemesanan hotel</p>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $bookings->count() }}</h3>
                <p>Total Pemesanan</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $bookings->where('status', 'pending')->count() }}</h3>
                <p>Pending</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon confirmed">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                <p>Dikonfirmasi</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon cancelled">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                <p>Dibatalkan</p>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bookings-table">
        <div class="table-header">
            <h2>Semua Pemesanan</h2>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="real-time-indicator">
                    <span class="pulse-dot"></span>
                    <span>Real-time Update</span>
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="pending">Pending</button>
                    <button class="filter-btn" data-filter="confirmed">Confirmed</button>
                    <button class="filter-btn" data-filter="cancelled">Cancelled</button>
                </div>
            </div>
        </div>

        @if($bookings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tamu</th>
                    <th>Kamar</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="bookingsTableBody">
                @foreach($bookings as $booking)
                <tr class="booking-row" data-status="{{ $booking->status }}" data-id="{{ $booking->id }}">
                    <td data-label="ID"><strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                    <td data-label="Tamu">
                        <div>
                            <strong>{{ $booking->user->name }}</strong><br>
                            <small style="color: var(--accent-color);">{{ $booking->user->email }}</small>
                        </div>
                    </td>
                    <td data-label="Kamar">
                        <span class="room-type-tag" style="background: var(--primary-color); color: var(--secondary-color); padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.85rem;">
                            {{ $booking->room->type }}
                        </span> {{ $booking->room->number }}
                    </td>
                    <td data-label="Check-in">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                    <td data-label="Check-out">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                    <td data-label="Total"><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                    <td data-label="Status">
                        <span class="status-badge status-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td data-label="Pembayaran">
                        @php($payStatus = $booking->payment_status ?? 'unpaid')
                        <span class="pay-badge @if($payStatus === 'paid') pay-paid @else pay-unpaid @endif">
                            {{ $payStatus === 'paid' ? 'Sudah bayar' : 'Belum bayar' }}
                        </span>
                    </td>
                    <td data-label="Aksi">
                        <div class="action-buttons">
                            <button class="btn-icon btn-view" onclick="viewBooking(this)" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($booking->status == 'pending')
                            <button class="btn-icon btn-confirm" onclick="confirmBooking(this)" title="Konfirmasi">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn-icon btn-cancel" onclick="cancelBooking(this)" title="Batalkan">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-bookings">
            <i class="fas fa-calendar-times"></i>
            <h3>Belum ada pemesanan</h3>
            <p>Pemesanan akan muncul di sini</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const bookingRows = document.querySelectorAll('.booking-row');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const filter = btn.dataset.filter;
            bookingRows.forEach(row => {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // View booking
    function getBookingIdFromEl(el) {
        const row = el?.closest?.('.booking-row');
        return row?.dataset?.id;
    }

    function viewBooking(el) {
        const id = getBookingIdFromEl(el);
        if (!id) return;
        window.location.href = `/bookings/${id}`;
    }

    // Confirm booking
    function confirmBooking(el) {
        const id = getBookingIdFromEl(el);
        if (!id) return;
        if (confirm('Konfirmasi pemesanan ini?')) {
            updateBookingStatus(id, 'confirmed');
        }
    }

    // Cancel booking
    function cancelBooking(el) {
        const id = getBookingIdFromEl(el);
        if (!id) return;
        if (confirm('Batalkan pemesanan ini?')) {
            updateBookingStatus(id, 'cancelled');
        }
    }

    // Update booking status with better error handling
    function updateBookingStatus(id, status) {
        fetch(`/bookings/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        })
        .then(async response => {
            if (response.status === 419) {
                alert('Sesi kedaluwarsa, silakan login ulang.');
                window.location.href = '/login';
                return;
            }
            if (!response.ok) {
                throw new Error('Gagal memperbarui status');
            }

            const contentType = response.headers.get('content-type') || '';
            if (contentType.includes('application/json')) {
                try {
                    return await response.json();
                } catch (e) {
                    return { success: true, _nonJson: true };
                }
            }

            return { success: true, _nonJson: true };
        })
        .then(data => {
            if (data && data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Tidak bisa memperbarui status. Pastikan sudah login sebagai admin.');
        });
    }

    // Real-time updates placeholder (will be implemented with WebSocket)
    // For now, auto-refresh every 30 seconds
    setInterval(() => {
        // In production, this would be replaced with WebSocket updates
        console.log('Checking for updates...');
    }, 30000);
</script>
@endsection
