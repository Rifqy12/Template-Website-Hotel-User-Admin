<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type',
        'floor',
        'capacity',
        'price',
        'status',
        'description',
        'amenities',
        'image_url',
    ];

    protected $casts = [
        'floor' => 'integer',
        'capacity' => 'integer',
        'price' => 'decimal:2',
    ];

    public static function allowedFloorsForType(?string $type): ?array
    {
        $key = Str::slug(strtolower($type ?? ''), '');

        // Back-compat / variants
        if ($key === 'familyroom') {
            $key = 'family';
        }

        return match ($key) {
            'standard' => [1, 2, 3],
            'deluxe' => [4, 5, 6],
            'family' => [2, 3, 4],
            'suite' => [1],
            default => null,
        };
    }

    public function getImageUrlAttribute(): string
    {
        $provided = $this->attributes['image_url'] ?? null;
        if ($provided) {
            return $provided;
        }

        $typeKey = Str::slug(strtolower($this->type ?? ''), '');
        $defaults = [
            'standard' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80',
            'deluxe' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80',
            'suite' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80',
            'family' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'familyroom' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        ];

        return $defaults[$typeKey] ?? 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
