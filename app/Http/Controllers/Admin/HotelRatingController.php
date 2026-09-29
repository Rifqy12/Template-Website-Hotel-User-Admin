<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelRating;

class HotelRatingController extends Controller
{
    public function index()
    {
        $ratings = HotelRating::query()
            ->with('user:id,name,email')
            ->orderByDesc('created_at')
            ->limit(500)
            ->get();

        $count = (int) HotelRating::count();
        $avg = (float) (HotelRating::avg('rating') ?? 0);

        $distribution = HotelRating::query()
            ->selectRaw('rating, COUNT(*) as aggregate')
            ->groupBy('rating')
            ->orderBy('rating')
            ->get()
            ->mapWithKeys(fn ($row) => [(int) $row->rating => (int) $row->aggregate])
            ->all();

        return view('admin.ratings.index', [
            'ratings' => $ratings,
            'ratingStats' => [
                'count' => $count,
                'avg' => $avg,
                'distribution' => $distribution,
            ],
        ]);
    }
}
