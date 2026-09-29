<?php

use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!DB::getSchemaBuilder()->hasTable('rooms')) {
            return;
        }

        // Backfill floor from first digit of the 3-digit room number.
        Room::query()
            ->select(['id', 'number'])
            ->orderBy('id')
            ->chunkById(200, function ($rooms) {
                foreach ($rooms as $room) {
                    $number = (string) ($room->number ?? '');
                    if ($number === '' || !ctype_digit($number)) {
                        continue;
                    }

                    $floor = (int) substr($number, 0, 1);
                    DB::table('rooms')->where('id', $room->id)->update(['floor' => $floor]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // no-op
    }
};
