<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    private function canManageBooking(Booking $booking): bool
    {
        if (!Auth::check()) {
            return false;
        }

        if (Auth::user()->role === 'admin') {
            return true;
        }

        return $booking->user_id === Auth::id();
    }

    public function index()
    {
        $bookings = Booking::with(['room', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('rooms.index')->with('error', 'Admin tidak dapat membuat pemesanan. Gunakan halaman booking untuk kelola pesanan.');
        }

        $roomId = $request->query('room_id');
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');

        $room = null;
        if ($roomId) {
            $room = Room::findOrFail($roomId);
        }

        return view('bookings.create', compact('room', 'checkIn', 'checkOut'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melanjutkan booking.');
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('rooms.index')->with('error', 'Admin tidak dapat membuat pemesanan.');
        }

        $request->merge([
            'guest_name' => Auth::user()->name,
            'guest_email' => Auth::user()->email,
            'guest_phone' => Auth::user()->phone,
        ]);

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'notes' => 'nullable|string',
        ]);

        $room = Room::findOrFail($request->room_id);
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkOut->diffInDays($checkIn);

        // Check if room is available
        $isAvailable = !Booking::where('room_id', $request->room_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function ($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                      });
            })->exists();

        if (!$isAvailable) {
            return back()->withErrors(['error' => 'Kamar tidak tersedia untuk tanggal yang dipilih.'])->withInput();
        }

        // Get or create user
        $user = Auth::user();

        // Calculate total price
        $totalPrice = $room->price * $nights;

        // Create booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'room_id' => $request->room_id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => 'pending',
            'total_price' => $totalPrice,
            'notes' => $request->notes,
        ]);

        // Broadcast event for real-time update
        event(new \App\Events\BookingCreated($booking));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibuat!',
                'booking' => $booking->load(['room', 'user'])
            ]);
        }

        return redirect()->route('bookings.confirmation', $booking->id)
            ->with('success', 'Booking berhasil dibuat!');
    }

    public function show($id)
    {
        $booking = Booking::with(['room', 'user'])->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    public function confirmation($id)
    {
        $booking = Booking::with(['room', 'user'])->findOrFail($id);
        return view('bookings.confirmation', compact('booking'));
    }

    public function pay($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $booking = Booking::with(['room', 'user'])->findOrFail($id);

        if (!$this->canManageBooking($booking)) {
            return redirect()->route('bookings.history')->with('error', 'Anda tidak dapat mengakses pembayaran booking ini.');
        }

        if ($booking->status === 'cancelled') {
            return redirect()->route('bookings.history')->with('error', 'Booking yang dibatalkan tidak dapat dibayar.');
        }

        return view('bookings.payment', compact('booking'));
    }

    public function updatePayment(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $booking = Booking::with(['room', 'user'])->findOrFail($id);

        if (!$this->canManageBooking($booking)) {
            return back()->with('error', 'Anda tidak dapat mengubah pembayaran untuk booking ini.');
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking yang dibatalkan tidak dapat dibayar.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:qris,bank_transfer,ewallet,cash',
            'payment_reference' => 'nullable|string|max:100',
            'action' => 'required|in:mark_paid,mark_unpaid',
        ]);

        if (
            $validated['action'] === 'mark_unpaid'
            && $booking->status === 'confirmed'
            && Auth::user()->role !== 'admin'
        ) {
            return back()->with('error', 'Booking sudah dikonfirmasi. Silakan hubungi admin untuk mengubah status pembayaran.');
        }

        $booking->payment_method = $validated['payment_method'];
        $booking->payment_reference = $validated['payment_reference'] ?? null;

        if ($validated['action'] === 'mark_paid') {
            $booking->payment_status = 'paid';
            $booking->paid_at = now();
        } elseif ($validated['action'] === 'mark_unpaid') {
            $booking->payment_status = 'unpaid';
            $booking->paid_at = null;
        }

        $booking->save();

        $message = match ($validated['action']) {
            'mark_paid' => 'Pembayaran berhasil dikonfirmasi (simulasi).',
            'mark_unpaid' => 'Status pembayaran direset ke belum dibayar.',
        };

        return back()->with('success', $message);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking = Booking::with('room')->findOrFail($id);
        $booking->update(['status' => $request->status]);

        // Keep room status in sync for admin operations.
        // We only mark the room as booked when there is an active booking today.
        // If a booking is cancelled and no other active booking remains today, mark it available again.
        $today = Carbon::today();
        $hasActiveBookingToday = Booking::where('room_id', $booking->room_id)
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '<=', $today)
            ->where('check_out', '>', $today)
            ->exists();

        if ($booking->room && $booking->room->status !== 'maintenance') {
            $booking->room->status = $hasActiveBookingToday ? 'booked' : 'available';
            $booking->room->save();
        }

        // Broadcast event for real-time update
        event(new \App\Events\BookingStatusUpdated($booking));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status booking berhasil diupdate!',
                'booking' => $booking->load(['room', 'user'])
            ]);
        }

        return back()->with('success', 'Status booking berhasil diupdate!');
    }

    public function updateDates(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $booking = Booking::with('room')->findOrFail($id);

        if ($booking->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah booking ini.');
        }

        if ($booking->status !== 'pending') {
            $message = match ($booking->status) {
                'confirmed' => 'Booking sudah dikonfirmasi dan tidak dapat diubah jadwalnya.',
                'cancelled' => 'Booking yang dibatalkan tidak dapat diubah.',
                default => 'Booking tidak dapat diubah pada status saat ini.',
            };

            return back()->with('error', $message);
        }

        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);

        $isAvailable = !Booking::where('room_id', $booking->room_id)
            ->where('id', '!=', $booking->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function ($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                      });
            })->exists();

        if ($isAvailable) {
            $nights = $checkOut->diffInDays($checkIn);
            $booking->check_in = $checkIn;
            $booking->check_out = $checkOut;
            $booking->total_price = $booking->room->price * $nights;
            $booking->save();

            return back()->with('success', 'Tanggal booking berhasil diperbarui.');
        }

        return back()->with('error', 'Tanggal baru bentrok dengan booking lain. Pilih rentang tanggal berbeda.');
    }

    public function destroy($id)
    {
        $booking = Booking::with('room')->findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        // If this cancellation makes the room free for today, make it available again.
        $today = Carbon::today();
        $hasActiveBookingToday = Booking::where('room_id', $booking->room_id)
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '<=', $today)
            ->where('check_out', '>', $today)
            ->exists();

        if ($booking->room && $booking->room->status !== 'maintenance') {
            $booking->room->status = $hasActiveBookingToday ? 'booked' : 'available';
            $booking->room->save();
        }

        // Broadcast event for real-time update
        event(new \App\Events\BookingStatusUpdated($booking));

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibatalkan!'
            ]);
        }

        return back()->with('success', 'Booking berhasil dibatalkan!');
    }

    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $bookings = Booking::with(['room'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.my-bookings', compact('bookings'));
    }

    // Backward compatibility
    public function myBookings()
    {
        return $this->history();
    }

    public function getAvailableRooms(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        $availableRooms = Room::where('status', 'available')
            ->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
                $q->where('status', '!=', 'cancelled')
                  ->where(function ($query) use ($checkIn, $checkOut) {
                      $query->whereBetween('check_in', [$checkIn, $checkOut])
                            ->orWhereBetween('check_out', [$checkIn, $checkOut])
                            ->orWhere(function ($q) use ($checkIn, $checkOut) {
                                $q->where('check_in', '<=', $checkIn)
                                  ->where('check_out', '>=', $checkOut);
                            });
                  });
            })->get();

        return response()->json([
            'success' => true,
            'rooms' => $availableRooms,
            'nights' => $checkOut->diffInDays($checkIn)
        ]);
    }
}
