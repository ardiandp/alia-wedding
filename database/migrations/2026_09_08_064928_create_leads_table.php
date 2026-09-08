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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('partner_name')->nullable();
            $table->string('email');
            $table->string('whatsapp');
            $table->date('wedding_date')->nullable();
            $table->unsignedInteger('estimated_guests')->nullable();
            $table->foreignId('venue_id')->nullable()->constrained()->nullOnDelete();
            $table->string('preferred_venue')->nullable();
            $table->string('wedding_style')->nullable();
            $table->string('budget_range')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', [
                'new', 'contacted', 'consultation', 'proposal_sent',
                'negotiation', 'confirmed', 'completed', 'cancelled',
            ])->default('new');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('last_contact_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
