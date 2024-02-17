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
        if(!Schema::hasTable('deal_tasks'))
        {
            Schema::create('deal_tasks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('deal_id');
                $table->string('name');
                $table->date('date');
                $table->time('time');
                $table->string('priority');
                $table->string('status');
                $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
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
        Schema::dropIfExists('deal_tasks');
    }
};
