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
        if (!Schema::hasColumn('users', 'verification_sent_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('verification_sent_at')->nullable()->after('email_verified_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'verification_sent_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('verification_sent_at');
            });
        }
    }
};
