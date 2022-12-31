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
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->char('country', 2);
            $table->enum('status', ['pending', 'cancelled', 'processing', 'shipped', 'completed']);
            $table->enum('payment_status', ['pending', 'paid', 'failed']);
            $table->float('total')->default(0);
            $table->char('currency', 3);
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
