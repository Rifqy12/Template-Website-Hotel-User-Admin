<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Return list of rooms.
     */
    public function index(Request $request)
    {
        $rooms = Room::orderBy('number')->get();
        return response()->json($rooms);
    }
}
