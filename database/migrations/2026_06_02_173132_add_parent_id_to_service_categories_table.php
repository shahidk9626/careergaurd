<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('service_categories', 'parent_id')) {
            Schema::table('service_categories', function (Blueprint $table) {
                $table->foreignId('parent_id')->nullable()->after('id')->constrained('service_categories')->onDelete('cascade');
            });
        }

        // Seed 3 parent categories
        $parents = [
            ['name' => 'Resume', 'slug' => 'resume', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Interview', 'slug' => 'interview', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Job Link', 'slug' => 'job-link', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($parents as $parent) {
            DB::table('service_categories')->insertOrIgnore($parent);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
