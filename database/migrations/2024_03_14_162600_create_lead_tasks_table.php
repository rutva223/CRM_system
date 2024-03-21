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
        if(!Schema::hasTable('lead_tasks'))
        {
            Schema::create('lead_tasks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('lead_id');
                $table->string('name');
                $table->date('date');
                $table->time('time');
                $table->string('priority');
                $table->string('status');
                $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
                $table->integer('created_by');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_tasks');
    }
};
