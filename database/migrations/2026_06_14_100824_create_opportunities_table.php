<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunities', function (
            Blueprint $table
        ) {

            $table->id();

            $table->foreignId('topic_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('trend_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->decimal(
                'score',
                10,
                2
            )->default(0);

            $table->text('reason')
                ->nullable();

            $table->timestamp(
                'detected_at'
            )->nullable();

            $table->timestamps();

            $table->unique('trend_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'opportunities'
        );
    }
};
