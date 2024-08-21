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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('transaction_code'); //transaction code
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('courier');
            $table->string('service');
            $table->bigInteger('cost_courier');
            $table->integer('weight');
            $table->string('name');
            $table->bigInteger('phone');
            $table->integer('province');
            $table->integer('city');
            $table->text('address');
            $table->enum('status_payment', array('pending', 'success', 'failed', 'expired'));
            $table->enum('status_shipping', array('pending', 'disiapkan', 'dikirim', 'selesai'));
            // $table->string('snap_token')->nullable();
            $table->bigInteger('grand_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
