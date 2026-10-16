<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255);
            $table->string('route_name', 100)->nullable();
            $table->string('page_title', 255)->nullable();
            $table->char('visitor_hash', 64);
            $table->char('ip_hash', 64)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('referrer', 255)->nullable();
            $table->string('referrer_host', 150)->nullable();
            $table->string('device', 20)->nullable();
            $table->boolean('is_bot')->default(false);
            $table->timestamp('visited_at');
            $table->timestamps();

            $table->index('visited_at');
            $table->index('path');
            $table->index(['visitor_hash', 'visited_at']);
            $table->index(['is_bot', 'visited_at']);
            $table->index('referrer_host');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
