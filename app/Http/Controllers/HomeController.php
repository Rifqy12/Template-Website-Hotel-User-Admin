<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\HotelRating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $todayStart = Carbon::today();
            $todayEnd = Carbon::tomorrow();

            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();

            $bookingsByStatus = Booking::query()
                ->selectRaw('status, COUNT(*) as aggregate')
                ->groupBy('status')
                ->orderBy('status')
                ->get()
                ->map(fn ($row) => ['status' => $row->status, 'count' => (int) $row->aggregate])
                ->values()
                ->all();

            $bookingsByPaymentStatus = Booking::query()
                ->selectRaw('payment_status, COUNT(*) as aggregate')
                ->groupBy('payment_status')
                ->orderBy('payment_status')
                ->get()
                ->map(fn ($row) => ['payment_status' => $row->payment_status, 'count' => (int) $row->aggregate])
                ->values()
                ->all();

            $stats = [
                'rooms_total' => Room::count(),
                'rooms_available' => Room::where('status', 'available')->count(),
                'bookings_total' => Booking::count(),
                'bookings_today' => Booking::where('created_at', '>=', $todayStart)
                    ->where('created_at', '<', $todayEnd)
                    ->count(),
                'bookings_month' => Booking::where('created_at', '>=', $monthStart)
                    ->where('created_at', '<=', $monthEnd)
                    ->count(),
                'bookings_by_status' => $bookingsByStatus,
                'bookings_by_payment_status' => $bookingsByPaymentStatus,
            ];

            return view('admin.dashboard', compact('stats'));
        }

        $featuredRooms = Room::where('status', 'available')
            ->take(6)
            ->get();
        
        $roomTypes = Room::select('type')->distinct()->get();
        
        return view('home', compact('featuredRooms', 'roomTypes'));
    }

    public function about()
    {
        $stats = [
            'count' => HotelRating::count(),
            'avg' => (float) (HotelRating::avg('rating') ?? 0),
        ];

        $myRating = null;
        if (Auth::check()) {
            $myRating = HotelRating::where('user_id', Auth::id())->value('rating');
        }

        return view('about', [
            'ratingStats' => $stats,
            'myRating' => $myRating,
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')->with('success', 'Terima kasih! Pesan Anda sudah terkirim.');
    }

    public function submitRating(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'guest') {
            return redirect()->route('about')->with('error', 'Silakan login sebagai customer untuk memberi rating.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        HotelRating::updateOrCreate(
            ['user_id' => Auth::id()],
            ['rating' => (int) $validated['rating']]
        );

        return redirect()->route('about')->with('success', 'Terima kasih! Rating kamu sudah tersimpan.');
    }
}
