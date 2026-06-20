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
        Schema::table(
            'topic_keywords',
            function (Blueprint $table) {

                $table
                    ->string('status')
                    ->default('active')
                    ->after('weight')
                    ->index();
            }
        );

        DB::table('topic_keywords')
            ->update([
                'status' => 'active',
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'topic_keywords',
            function (Blueprint $table) {

                $table->dropIndex([
                    'status',
                ]);

                $table->dropColumn(
                    'status'
                );
            }
        );
    }
};
