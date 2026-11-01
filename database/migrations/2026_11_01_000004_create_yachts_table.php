<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yachts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('type', 20);
            $table->string('image');
            $table->decimal('length_m', 5, 1);
            $table->unsignedTinyInteger('guest_capacity');
            $table->unsignedTinyInteger('cabins');
            $table->unsignedTinyInteger('crew_size')->nullable();
            $table->unsignedSmallInteger('build_year');
            $table->unsignedSmallInteger('max_speed_knots')->nullable();
            $table->unsignedSmallInteger('cruising_speed_knots')->nullable();
            $table->unsignedSmallInteger('range_nm')->nullable();
            $table->unsignedBigInteger('weekly_rate_usd')->nullable();
            $table->text('description');
            $table->text('overview');
            $table->json('cruising_regions');
            $table->json('amenities');
            $table->boolean('is_illustrative')->default(true);
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();

            $table->index(['type', 'guest_capacity']);
            $table->index('weekly_rate_usd');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yachts');
    }
};
