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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_exp_month')->nullable();
            $table->string('card_exp_year')->nullable();
            $table->string('plan_name')->nullable();
            $table->integer('plan_id')->nullable();
            $table->string('price')->nullable();
            $table->string('price_currency')->nullable();
            $table->string('payment_type', 100)->nullable();
            $table->string('payment_status', 100);
            $table->string('receipt')->nullable();
            $table->integer('user_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
