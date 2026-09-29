<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRating extends Model
{
    protected $fillable = [
        'user_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
        'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
