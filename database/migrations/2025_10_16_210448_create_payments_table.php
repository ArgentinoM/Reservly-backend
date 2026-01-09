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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_id')->unique()->nullable();
            $table->unsignedBigInteger('amount');
            $table->string('currency', 10)->default('mxn');
            $table->string('receipt_url')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->json('raw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
