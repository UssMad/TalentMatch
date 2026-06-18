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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_offer_id')->constrained()->cascadeOnDelete();
            $table->json('structured_data');
            $table->integer('matching_score');
            $table->string('recommendation');
            $table->json('raw_ai_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
