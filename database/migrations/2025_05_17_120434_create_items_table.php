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
        Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('amount', 10, 2);
        $table->foreignId('brand_id')->constrained()->onDelete('cascade');
        $table->foreignId('device_model_id')->nullable()->constrained()->onDelete('set null');
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
        Schema::dropIfExists('items');
    }
};
