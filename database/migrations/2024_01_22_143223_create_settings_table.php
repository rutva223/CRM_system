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
        if(!Schema::hasTable('settings'))
        {
            Schema::create('settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('value')->nullable();
                $table->integer('created_by');
                $table->timestamps();
                $table->unique(['name', 'created_by']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
