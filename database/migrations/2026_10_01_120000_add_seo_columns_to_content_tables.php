<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('og_image')->nullable()->after('meta_description');
            $table->string('canonical_url')->nullable()->after('og_image');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('og_image')->nullable()->after('meta_description');
            $table->string('canonical_url')->nullable()->after('og_image');
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->string('canonical_url')->nullable()->after('og_image');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->string('canonical_url')->nullable()->after('og_image');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['og_image', 'canonical_url']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['og_image', 'canonical_url']);
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('canonical_url');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('canonical_url');
        });
    }
};
