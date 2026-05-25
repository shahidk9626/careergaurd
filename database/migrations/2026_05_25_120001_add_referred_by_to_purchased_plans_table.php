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
        Schema::table('purchased_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('purchased_plans', 'referred_by')) {
                $table->foreignId('referred_by')->nullable()->after('status')->constrained('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchased_plans', function (Blueprint $table) {
            if (Schema::hasColumn('purchased_plans', 'referred_by')) {
                $table->dropForeign(['referred_by']);
                $table->dropColumn('referred_by');
            }
        });
    }
};
