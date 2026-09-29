<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        $types = ['standard', 'deluxe', 'suite', 'family'];
        $type = $this->faker->randomElement($types);

        $allowedFloors = Room::allowedFloorsForType($type) ?? [1];
        $floor = (int) $this->faker->randomElement($allowedFloors);

        // 3-digit room number: first digit = floor, last two digits = room index
        $number = $this->faker->unique()->numerify(sprintf('%d##', $floor));

        return [
            'number' => $number,
            'type' => $type,
            'floor' => $floor,
            'capacity' => $this->faker->randomElement([1,2,3,4]),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'status' => 'available',
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
