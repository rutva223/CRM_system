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
        if(!Schema::hasTable('deal_discussions'))
        {
            Schema::create('deal_discussions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('deal_id');
                $table->text('comment');
                $table->integer('created_by');
                $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_discussions');
    }
};
