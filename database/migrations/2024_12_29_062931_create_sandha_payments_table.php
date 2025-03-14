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
        Schema::create('subscription_payments', function (Blueprint $table) {
          $table->id();
          $table->integer('customer_id'); // Foreign key to customers table
          $table->integer('subscription_plan_id'); // Foreign key to subscriptions table
          $table->decimal('amount_paid', 10, 2); // Amount paid by the customer
          $table->date('payment_date'); // Payment date
          $table->string('payment_method')->nullable(); // Optional: Payment method (e.g., Credit Card, Bank Transfer, etc.)
          $table->string('transaction_id')->nullable(); // Optional: Transaction ID for the payment
          $table->string('customer_photo')->nullable();
          $table->integer('added_by')->nullable();
          $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_payments');
    }
};
