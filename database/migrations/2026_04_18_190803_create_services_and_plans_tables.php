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
        // Resume Templates
        Schema::create('resume_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
            $table->softDeletes();
        });

        // Job Links
        Schema::create('job_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company_name')->nullable();
            $table->string('job_url');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Interview Questions
        Schema::create('interview_questions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->text('question_text');
            $table->text('answer_text')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Plans
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->decimal('premium_amount', 10, 2);
            $table->string('tenure_type'); // monthly, yearly, lifetime, custom
            $table->integer('tenure_value')->nullable();
            $table->integer('claim_duration_days')->default(0);
            $table->decimal('compensation_amount', 10, 2)->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Plan Services (Pivot)
        Schema::create('plan_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->string('service_type'); // resume_template, job_link, interview_question, claim
            $table->unsignedBigInteger('service_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_services');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('interview_questions');
        Schema::dropIfExists('job_links');
        Schema::dropIfExists('resume_templates');
    }
};
