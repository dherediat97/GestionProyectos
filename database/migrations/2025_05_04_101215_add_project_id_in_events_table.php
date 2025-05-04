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
        Schema::table('events', function (Blueprint $table) {
            // Add the 'project_id' column to the 'events' table
            $table->foreignId('project_id')
                ->after('text')
                ->constrained('projects')
                ->onDelete('cascade')
                ->default(1)
                ->comment('ID of the project associated with the event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
