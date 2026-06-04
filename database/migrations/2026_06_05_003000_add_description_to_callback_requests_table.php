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
        Schema::table('callback_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('callback_requests', 'description')) {
                $table->text('description')->nullable()->after('concern');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('callback_requests', function (Blueprint $table) {
            if (Schema::hasColumn('callback_requests', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
