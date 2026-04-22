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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // Many-to-Many for Resume Templates
        Schema::create('resume_template_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_template_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_category_id')->constrained()->onDelete('cascade');
        });

        // Many-to-Many for Job Links
        Schema::create('job_link_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_link_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_category_id')->constrained()->onDelete('cascade');
        });

        // Many-to-Many for Interview Questions
        Schema::create('interview_question_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_category_id')->constrained()->onDelete('cascade');
        });

        // Update plan_services to handle categories
        Schema::table('plan_services', function (Blueprint $table) {
            $table->foreignId('service_category_id')->nullable()->after('service_id')->constrained('service_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_services', function (Blueprint $table) {
            $table->dropForeign(['service_category_id']);
            $table->dropColumn('service_category_id');
        });
        Schema::dropIfExists('interview_question_categories');
        Schema::dropIfExists('job_link_categories');
        Schema::dropIfExists('resume_template_categories');
        Schema::dropIfExists('service_categories');
    }
};
