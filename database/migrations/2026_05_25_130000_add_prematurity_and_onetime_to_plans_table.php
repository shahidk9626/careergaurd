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
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'prematurity_available')) {
                $table->boolean('prematurity_available')->default(0)->after('status');
            }
            if (!Schema::hasColumn('plans', 'one_time_payment_applicable')) {
                $table->boolean('one_time_payment_applicable')->default(0)->after('prematurity_available');
            }
            if (!Schema::hasColumn('plans', 'one_time_payment_amount')) {
                $table->decimal('one_time_payment_amount', 15, 2)->nullable()->after('one_time_payment_applicable');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'prematurity_available')) {
                $table->dropColumn('prematurity_available');
            }
            if (Schema::hasColumn('plans', 'one_time_payment_applicable')) {
                $table->dropColumn('one_time_payment_applicable');
            }
            if (Schema::hasColumn('plans', 'one_time_payment_amount')) {
                $table->dropColumn('one_time_payment_amount');
            }
        });
    }
};
