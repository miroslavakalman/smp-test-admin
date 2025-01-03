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
            if (!Schema::hasColumn('bookings', column: 'in_club_status')) {
                $table->enum('in_club_status', ['yes', 'no'])->default('no');
            }
            if (!Schema::hasColumn('bookings', 'sim_setup')) {
                $table->enum('sim_setup', ['yes', 'no'])->default('no');
            }
           
            if (!Schema::hasColumn('bookings', 'created_at') || !Schema::hasColumn('bookings', 'updated_at')) {
                $table->timestamps();
            }
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Удаляем добавленные колонки
            $table->dropColumn(['in_club_status', 'sim_setup']);
 
        });
    }
};
