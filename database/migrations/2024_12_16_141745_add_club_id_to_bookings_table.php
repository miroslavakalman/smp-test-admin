<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_add_club_id_to_bookings_table.php

// database/migrations/xxxx_xx_xx_add_club_id_to_bookings_table.php

public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->foreignId('club_id')->nullable()->constrained()->onDelete('cascade'); // Добавлено nullable()
    });
}

};
