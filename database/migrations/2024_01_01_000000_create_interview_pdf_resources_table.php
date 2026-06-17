<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_pdf_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('interview_pdf_resource_category', function (Blueprint $table) {
            $table->unsignedBigInteger('pdf_resource_id');
            $table->unsignedBigInteger('category_id');
            $table->primary(['pdf_resource_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_pdf_resource_category');
        Schema::dropIfExists('interview_pdf_resources');
    }
};