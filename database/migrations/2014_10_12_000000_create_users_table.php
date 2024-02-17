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
        if(!Schema::hasTable('users'))
        {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('type', 20);
                $table->string('avatar', 100)->nullable();
                $table->string('lang', 100);
                $table->integer('plan')->nullable();
                $table->integer('total_user')->default(0);
                $table->date('plan_expire_date')->nullable();
                $table->string('theme_setting', 20)->default('light');
                $table->string('default_pipeline')->nullable();
                $table->integer('created_by')->default(0);
                $table->integer('is_active')->default(1);
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
