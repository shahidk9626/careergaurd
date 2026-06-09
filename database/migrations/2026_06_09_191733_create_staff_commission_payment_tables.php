<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_commission_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->string('batch_reference')->unique();
            $table->integer('total_policies');
            $table->decimal('total_commission_amount', 10, 2);
            $table->string('payment_proof')->nullable();
            $table->text('description')->nullable();
            $table->date('payment_date');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('staff_commission_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('purchased_plan_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('plan_id');
            $table->decimal('commission_amount', 10, 2);
            $table->string('status')->default('Pending'); // Pending, Paid, Hold, Rejected
            $table->text('description')->nullable(); // Hold/Rejected reason
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('staff_commission_payments')->onDelete('cascade');
            $table->foreign('purchased_plan_id')->references('id')->on('purchased_plans')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_commission_payment_details');
        Schema::dropIfExists('staff_commission_payments');
    }
};
