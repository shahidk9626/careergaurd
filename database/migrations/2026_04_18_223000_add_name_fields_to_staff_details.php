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
        Schema::table('staff_details', function (Blueprint $table) {
            if (!Schema::hasColumn('staff_details', 'first_name')) {
                $table->string('first_name')->after('user_id');
                $table->string('last_name')->nullable()->after('first_name');
                $table->string('full_name')->nullable()->after('last_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_details', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'full_name']);
        });
    }
};
