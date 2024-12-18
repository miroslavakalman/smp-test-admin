<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('clubs', function (Blueprint $table) {
        $table->integer('pc_count')->nullable()->after('name');
        $table->time('opening_time')->nullable()->after('pc_count');
        $table->time('closing_time')->nullable()->after('opening_time');
    });
}


public function down(): void
{
    Schema::table('clubs', function (Blueprint $table) {
        $table->dropColumn(['pc_count', 'opening_time', 'closing_time']);
    });
}

};
