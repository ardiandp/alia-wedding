<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('click_events', function (Blueprint $table) {
            $table->id();
            $table->string('label', 60)->index();
            $table->string('path', 255)->nullable();
            $table->string('target', 255)->nullable();
            $table->char('visitor_hash', 64);
            $table->char('ip_hash', 64)->nullable();
            $table->timestamp('created_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('click_events');
    }
};
