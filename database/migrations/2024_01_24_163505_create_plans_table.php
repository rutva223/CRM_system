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
        if(!Schema::hasTable('plans'))
        {
            Schema::create('plans', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 100);
                $table->string('price');
                $table->string('max_user', 100)->default(0);
                $table->string('max_customer', 100)->default(0);
                $table->string('max_vendor', 100)->default(0);
                $table->string('duration');
                $table->string('description');
                $table->integer('is_free_plan')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
