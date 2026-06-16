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
        Schema::create('sources', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('type');

            $table->string('status')
                ->default('active');

            $table->json('config');

            $table->timestamp('last_crawled_at')
                ->nullable();

            $table->timestamps();

            $table->index('type');
            $table
                ->unsignedTinyInteger(
                    'authority_score'
                )
                ->default(50);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
