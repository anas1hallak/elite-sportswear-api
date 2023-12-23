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
            $table->increments('id');
            $table->string('customerName');
            $table->string('phoneNumber');
            $table->string('state');

            $table->string('address')->nullable();
            $table->string('qadmousName')->nullable();
            $table->string('qadmousNumber')->nullable();
            $table->string('qadmousBranch')->nullable();

            $table->double('totalPrice');
            $table->double('totalPriceAfterDiscount');
            $table->string('coachName')->nullable();
            $table->string('code')->nullable();

            $table->string('status');


            
            



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
