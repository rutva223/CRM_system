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
        if(!Schema::hasTable('lead_calls'))
        {
            Schema::create('lead_calls', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('lead_id');
                $table->string('subject');
                $table->string('call_type', 30);
                $table->string('duration', 20);
                $table->integer('user_id');
                $table->longText('description')->nullable();
                $table->text('call_result')->nullable();
                $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_calls');
    }
};
