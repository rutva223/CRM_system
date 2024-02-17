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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('f_name');
            $table->string('l_name');
            $table->string('phone_no');
            $table->string('assistants_name');
            $table->string('assistants_mail');
            $table->string('assistants_phone');
            $table->string('department_name');
            $table->date('dob');
            $table->string('social_media_profile');
            $table->longText('notes');
            $table->string('send_mail')->nullable()->default('off');
            // $table->string('billing_street')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->integer('billing_zip')->nullable();
            $table->string('billing_country')->nullable();
            // $table->string('shipping_street')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->integer('shipping_zip')->nullable();
            $table->string('shipping_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
