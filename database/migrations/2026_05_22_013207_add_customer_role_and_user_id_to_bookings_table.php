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
        // Add customer role if it doesn't exist
        if (!Illuminate\Support\Facades\DB::table('roles')->where('name', 'customer')->exists()) {
            Illuminate\Support\Facades\DB::table('roles')->insert([
                'id' => 3,
                'name' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Illuminate\Support\Facades\DB::table('roles')->where('name', 'customer')->delete();
    }
};
