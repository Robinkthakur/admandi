<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('last_message_at')->nullable();
            $table->boolean('buyer_blocked')->default(false);
            $table->boolean('seller_blocked')->default(false);
            $table->boolean('deleted_by_buyer')->default(false);
            $table->boolean('deleted_by_seller')->default(false);
            $table->unique(['listing_id', 'buyer_id', 'seller_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
