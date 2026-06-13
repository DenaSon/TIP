<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trends', function (
            Blueprint $table
        ) {

            $table->id();

            $table->foreignId('topic_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal(
                'growth_rate',
                10,
                2
            )->default(0);

            $table->decimal(
                'authority_score',
                10,
                2
            )->default(0);

            $table->decimal(
                'score',
                10,
                2
            )->default(0);

            $table->timestamp(
                'calculated_at'
            );

            $table->timestamps();

            $table->unique('topic_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'trends'
        );
    }
};
