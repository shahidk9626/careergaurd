<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_links', function (Blueprint $table) {
            $table->string('job_url')->nullable()->change();

            if (!Schema::hasColumn('job_links', 'contact_person_name'))
                $table->string('contact_person_name')->nullable()->after('company_name');

            if (!Schema::hasColumn('job_links', 'mobile_number'))
                $table->string('mobile_number')->nullable()->after('contact_person_name');

            if (!Schema::hasColumn('job_links', 'job_title'))
                $table->string('job_title')->nullable()->after('title');

            if (!Schema::hasColumn('job_links', 'vacancies'))
                $table->string('vacancies')->nullable()->after('job_title');

            if (!Schema::hasColumn('job_links', 'location'))
                $table->string('location')->nullable()->after('vacancies');

            if (!Schema::hasColumn('job_links', 'salary'))
                $table->string('salary')->nullable()->after('location');

            if (!Schema::hasColumn('job_links', 'experience'))
                $table->string('experience')->nullable()->after('salary');

            if (!Schema::hasColumn('job_links', 'apply_whatsapp_or_email'))
                $table->string('apply_whatsapp_or_email')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('job_links', function (Blueprint $table) {
            $table->string('job_url')->nullable(false)->change();

            $columns = [
                'contact_person_name', 'mobile_number', 'job_title',
                'vacancies', 'location', 'salary', 'experience', 'apply_whatsapp_or_email',
            ];

            $existing = array_filter($columns, fn($col) => Schema::hasColumn('job_links', $col));
            if ($existing) $table->dropColumn(array_values($existing));
        });
    }
};