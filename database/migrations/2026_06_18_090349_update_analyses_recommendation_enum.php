<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            UPDATE analyses
            SET recommendation = CASE recommendation
                WHEN 'Strongly Recommend' THEN 'convoquer'
                WHEN 'Recommend' THEN 'convoquer'
                WHEN 'Consider' THEN 'attente'
                WHEN 'Not Recommended' THEN 'rejeter'
                WHEN 'No Decision' THEN 'attente'
                ELSE recommendation
            END
        ");
    }

    public function down(): void
    {
        DB::statement("
            UPDATE analyses
            SET recommendation = CASE recommendation
                WHEN 'convoquer' THEN 'No Decision'
                WHEN 'attente' THEN 'No Decision'
                WHEN 'rejeter' THEN 'Not Recommended'
                ELSE recommendation
            END
        ");
    }
};
