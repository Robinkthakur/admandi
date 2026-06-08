<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('in_hn')->nullable();
            $table->string('in_pb')->nullable();
            $table->string('type'); // e.g. country, state, city, area
            $table->foreignId('parent_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
