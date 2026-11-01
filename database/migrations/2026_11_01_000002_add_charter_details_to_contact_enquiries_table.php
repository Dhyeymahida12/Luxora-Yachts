<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_enquiries', function (Blueprint $table) {
            $table->string('yacht')->nullable();
            $table->string('destination')->nullable();
            $table->date('charter_start_date')->nullable();
            $table->date('charter_end_date')->nullable();
            $table->unsignedTinyInteger('guests')->nullable();
            $table->string('budget')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contact_enquiries', function (Blueprint $table) {
            $table->dropColumn([
                'yacht',
                'destination',
                'charter_start_date',
                'charter_end_date',
                'guests',
                'budget',
            ]);
        });
    }
};
