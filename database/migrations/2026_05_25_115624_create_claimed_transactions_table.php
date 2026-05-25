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
        Schema::create('claimed_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_request_id')->constrained('claims')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('purchased_plan_id')->constrained('purchased_plans')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('plan_unique_id');
            $table->decimal('claim_amount', 15, 2);
            $table->string('transaction_screenshot');
            $table->string('status', 50)->default('approved');
            $table->text('remarks')->nullable();
            $table->foreignId('approved_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claimed_transactions');
    }
};
