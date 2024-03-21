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
        if(!Schema::hasTable('leads'))
        {
            Schema::create('leads', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->float('amount')->nullable();
                $table->string('email')->unique();
                $table->string('subject');
                $table->integer('user_id');
                $table->integer('pipeline_id');
                $table->integer('stage_id');
                $table->string('sources')->nullable();
                $table->string('products')->nullable();
                $table->text('notes')->nullable();
                $table->string('labels')->nullable();
                $table->integer('order')->default(0);
                $table->string('phone',20)->nullable();
                $table->integer('created_by');
                $table->integer('is_active')->default(1);
                $table->integer('is_converted')->default(0);
                $table->longText('description');
                $table->date('date')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
