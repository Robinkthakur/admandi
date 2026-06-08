<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('ad_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('subcategory_id');
            $table->foreign('subcategory_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('locations')->onDelete('cascade');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('locations')->onDelete('set null');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('locations')->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->integer('views')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
