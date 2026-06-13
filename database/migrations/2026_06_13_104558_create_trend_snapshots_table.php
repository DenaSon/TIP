<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trend_snapshots', function (
            Blueprint $table
        ) {

            $table->id();

            $table->foreignId('topic_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger(
                'content_count'
            );

            $table->timestamp(
                'captured_at'
            );

            $table->timestamps();

            $table->index([
                'topic_id',
                'captured_at',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'trend_snapshots'
        );
    }
};
