<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_packages', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->string('name');
            $table->integer('duration_in_months');
            $table->decimal('price', 10, 2);
            $table->integer('featured_limit');
            $table->string('color')->default('primary');
            $table->string('badge')->nullable();
            $table->boolean('popular')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_packages');
    }
};
