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
        Schema::create('contents', function (Blueprint $table) {

            $table->id();

            $table->foreignId('source_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('external_id')
                ->nullable();

            $table->string('title');

            $table->string('url')
                ->nullable();

            $table->text('excerpt')
                ->nullable();

            $table->longText('content')
                ->nullable();

            $table->json('raw_payload')
                ->nullable();

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'source_id',
                'external_id',
            ]);

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
