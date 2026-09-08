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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->unsignedInteger('size')->nullable();
            $table->enum('type', ['indoor', 'outdoor', 'indoor_outdoor'])->default('indoor_outdoor')->comment('indoor|outdoor|indoor_outdoor');
            $table->string('hero_image')->nullable();
            $table->string('floor_plan')->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->text('facility_note')->nullable();
            $table->text('parking')->nullable();
            $table->text('catering')->nullable();
            $table->text('decoration')->nullable();
            $table->string('address')->nullable();
            $table->string('google_maps_embed')->nullable();
            $table->decimal('starting_price', 15, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
