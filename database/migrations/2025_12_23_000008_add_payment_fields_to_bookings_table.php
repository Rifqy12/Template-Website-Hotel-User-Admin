<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_status', 20)->default('unpaid')->after('status');
            $table->string('payment_method', 50)->nullable()->after('payment_status');
            $table->string('payment_reference', 100)->nullable()->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('payment_reference');

            $table->index(['payment_status', 'payment_method']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['payment_status', 'payment_method']);
            $table->dropColumn(['payment_status', 'payment_method', 'payment_reference', 'paid_at']);
        });
    }
};
