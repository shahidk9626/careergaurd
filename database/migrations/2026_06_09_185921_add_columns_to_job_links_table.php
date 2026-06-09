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
        Schema::table('job_links', function (Blueprint $table) {
            $table->string('job_url')->nullable()->change();
            
            $table->string('contact_person_name')->nullable()->after('company_name');
            $table->string('mobile_number')->nullable()->after('contact_person_name');
            $table->string('job_title')->nullable()->after('title');
            $table->string('vacancies')->nullable()->after('job_title');
            $table->string('location')->nullable()->after('vacancies');
            $table->string('salary')->nullable()->after('location');
            $table->string('experience')->nullable()->after('salary');
            $table->string('apply_whatsapp_or_email')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_links', function (Blueprint $table) {
            $table->string('job_url')->nullable(false)->change();
            
            $table->dropColumn([
                'contact_person_name',
                'mobile_number',
                'job_title',
                'vacancies',
                'location',
                'salary',
                'experience',
                'apply_whatsapp_or_email',
            ]);
        });
    }
};
