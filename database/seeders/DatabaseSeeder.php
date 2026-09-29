<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin Hotel Paradise',
            'email' => 'admin@hotelparadise.com',
            'role' => 'admin',
        ]);

        // Create test users
        User::factory()->create([
            'name' => 'Asep',
            'email' => 'asep@example.com',
            'role' => 'guest',
        ]);

        User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'role' => 'guest',
        ]);

        // Create rooms with different types
        // Standard Rooms
        $standardFloors = [1, 2, 3];
        for ($i = 1; $i <= 5; $i++) {
            $floor = $standardFloors[($i - 1) % count($standardFloors)];
            $number = (string) (($floor * 100) + $i);
            \App\Models\Room::create([
                'number' => $number,
                'type' => 'Standard',
                'capacity' => 2,
                'price' => 500000,
                'status' => 'available',
                'description' => 'Kamar standard dengan fasilitas AC, TV, WiFi, dan kamar mandi dalam.'
            ]);
        }

        // Deluxe Rooms
        $deluxeFloors = [4, 5, 6];
        for ($i = 1; $i <= 4; $i++) {
            $floor = $deluxeFloors[($i - 1) % count($deluxeFloors)];
            $number = (string) (($floor * 100) + $i);
            \App\Models\Room::create([
                'number' => $number,
                'type' => 'Deluxe',
                'capacity' => 2,
                'price' => 850000,
                'status' => 'available',
                'description' => 'Kamar deluxe dengan fasilitas lengkap, balkon pribadi, mini bar, dan pemandangan kota.'
            ]);
        }

        // Suite Rooms
        for ($i = 1; $i <= 2; $i++) {
            $number = (string) ((1 * 100) + (50 + $i));
            \App\Models\Room::create([
                'number' => $number,
                'type' => 'Suite',
                'capacity' => 4,
                'price' => 1500000,
                'status' => 'available',
                'description' => 'Suite mewah dengan ruang tamu terpisah, jacuzzi, dapur kecil, dan pemandangan laut.'
            ]);
        }

        // Family Rooms
        $familyFloors = [2, 3, 4];
        for ($i = 1; $i <= 3; $i++) {
            $floor = $familyFloors[($i - 1) % count($familyFloors)];
            $number = (string) (($floor * 100) + (20 + $i));
            \App\Models\Room::create([
                'number' => $number,
                'type' => 'Family',
                'capacity' => 4,
                'price' => 1200000,
                'status' => 'available',
                'description' => 'Kamar family dengan 2 kamar tidur, cocok untuk keluarga dengan anak-anak.'
            ]);
        }
    }
}
