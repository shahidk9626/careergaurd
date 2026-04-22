<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('phone');
            $table->foreignId('referred_by_staff_id')->nullable()->after('role_id')->constrained('users')->nullOnDelete();
            $table->boolean('profile_completed')->default(0)->after('referred_by_staff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by_staff_id']);
            $table->dropColumn(['whatsapp_number', 'referred_by_staff_id', 'profile_completed']);
        });
    }
};
