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
        // Add Cashfree fields to transactions table
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'cashfree_order_id')) {
                $table->string('cashfree_order_id')->nullable()->after('transaction_reference');
            }
            if (!Schema::hasColumn('transactions', 'cashfree_payment_id')) {
                $table->string('cashfree_payment_id')->nullable()->after('cashfree_order_id');
            }
            if (!Schema::hasColumn('transactions', 'gateway_response')) {
                $table->longText('gateway_response')->nullable()->after('cashfree_payment_id');
            }
        });

        // Create payment_orders table
        if (!Schema::hasTable('payment_orders')) {
            Schema::create('payment_orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_id')->unique();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('plan_id')->constrained()->onDelete('cascade');
                $table->string('plan_unique_id');
                $table->decimal('amount', 15, 2);
                $table->string('payment_session_id')->nullable();
                $table->string('status')->default('pending'); // pending, success, failed
                $table->longText('gateway_response')->nullable();
                $table->timestamps();
            });
        }

        // Create payment_failures table
        if (!Schema::hasTable('payment_failures')) {
            Schema::create('payment_failures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('plan_id')->constrained()->onDelete('cascade');
                $table->string('order_id')->nullable();
                $table->text('error_message')->nullable();
                $table->longText('gateway_response')->nullable();
                $table->string('status')->default('failed');
                $table->timestamps(); // includes created_at and updated_at
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_failures');
        Schema::dropIfExists('payment_orders');

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['cashfree_order_id', 'cashfree_payment_id', 'gateway_response']);
        });
    }
};
