<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';

        // Always show all rooms in the list.
        // For guests, we only change the badge/CTA when there is an active booking today.
        $rooms = Room::query()
            ->withExists([
                'bookings as has_active_booking' => function ($q) use ($today) {
                    $q->where('status', '!=', 'cancelled')
                        ->where('check_in', '<=', $today)
                        ->where('check_out', '>', $today);
                },
            ])
            ->orderBy('number')
            ->get();

        return view('rooms.index', compact('rooms', 'isAdmin'));
    }

    public function show($id)
    {
        $today = Carbon::today();
        $room = Room::query()
            ->withExists([
                'bookings as has_active_booking' => function ($q) use ($today) {
                    $q->where('status', '!=', 'cancelled')
                        ->where('check_in', '<=', $today)
                        ->where('check_out', '>', $today);
                },
            ])
            ->findOrFail($id);
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';
        return view('rooms.show', compact('room', 'isAdmin'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'room_type' => 'nullable|string',
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        $query = Room::where('status', 'available');

        if ($request->room_type) {
            $query->where('type', $request->room_type);
        }

        $availableRooms = $query->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'rooms' => $availableRooms,
                'count' => $availableRooms->count()
            ]);
        }

        return view('rooms.index', [
            'rooms' => $availableRooms,
            'isAdmin' => false,
        ]);
    }

    public function getRoomTypes()
    {
        $types = Room::select('type')->distinct()->pluck('type');
        return response()->json($types);
    }

    /** Admin: edit room */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    /** Admin: create room */
    public function create()
    {
        return view('rooms.create');
    }

    /** Admin: store room */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => ['required', 'string', 'max:50', 'regex:/^\d{3}$/', 'unique:rooms,number'],
            'type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked,maintenance',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
        ]);

        $validator->after(function ($validator) use ($request) {
            $number = (string) $request->input('number');
            $floor = (int) substr($number, 0, 1);
            $allowed = Room::allowedFloorsForType($request->input('type'));

            if ($allowed !== null && !in_array($floor, $allowed, true)) {
                $validator->errors()->add('number', 'Nomor kamar tidak sesuai tipe (angka pertama harus lantai yang benar).');
            }
        });

        $validated = $validator->validate();

        $validated['floor'] = (int) substr((string) $validated['number'], 0, 1);

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Kamar baru berhasil ditambahkan');
    }

    /** Admin: update room */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'number' => ['required', 'string', 'max:50', 'regex:/^\d{3}$/', 'unique:rooms,number,' . $room->id],
            'type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked,maintenance',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
        ]);

        $validator->after(function ($validator) use ($request) {
            $number = (string) $request->input('number');
            $floor = (int) substr($number, 0, 1);
            $allowed = Room::allowedFloorsForType($request->input('type'));

            if ($allowed !== null && !in_array($floor, $allowed, true)) {
                $validator->errors()->add('number', 'Nomor kamar tidak sesuai tipe (angka pertama harus lantai yang benar).');
            }
        });

        $validated = $validator->validate();

        $validated['floor'] = (int) substr((string) $validated['number'], 0, 1);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Data kamar berhasil diperbarui');
    }
}
