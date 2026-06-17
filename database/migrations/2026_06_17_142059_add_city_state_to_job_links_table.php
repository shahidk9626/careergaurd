<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_links', function (Blueprint $table) {
            if (!Schema::hasColumn('job_links', 'city'))
                $table->string('city')->nullable()->after('location');
            if (!Schema::hasColumn('job_links', 'state'))
                $table->string('state')->nullable()->after('city');
        });
    }

    public function down(): void
    {
        Schema::table('job_links', function (Blueprint $table) {
            if (Schema::hasColumn('job_links', 'city'))   $table->dropColumn('city');
            if (Schema::hasColumn('job_links', 'state'))  $table->dropColumn('state');
        });
    }
};