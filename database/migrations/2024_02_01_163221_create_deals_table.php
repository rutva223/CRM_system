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
        if(!Schema::hasTable('deals'))
        {
            Schema::create('deals', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->float('price')->nullable();
                $table->integer('pipeline_id');
                $table->integer('stage_id');
                $table->string('sources')->nullable();
                $table->string('products')->nullable();
                $table->text('notes')->nullable();
                $table->string('labels')->nullable();
                $table->string('status')->nullable();
                $table->integer('order')->default(0);
                $table->string('phone')->nullable();
                $table->integer('created_by');
                $table->integer('is_active')->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
