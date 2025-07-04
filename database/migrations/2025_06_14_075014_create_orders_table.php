<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
    $table->string('name');
    $table->string('email');
    $table->string('phone');
    $table->text('address');
    $table->enum('payment_method', ['cod', 'stripe', 'paypal']);
    $table->decimal('total', 10, 2);
    $table->string('status')->default('pending');
    
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
