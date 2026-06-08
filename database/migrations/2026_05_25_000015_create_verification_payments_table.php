<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('verification_package_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->string('status')->default('pending'); // pending, success, failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_payments');
    }
};
