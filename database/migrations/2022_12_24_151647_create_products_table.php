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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->float('price')->default(0);
            $table->float('compare_price')->nullable();
            $table->unsignedBigInteger('quantity')->default(0);
            $table->enum('status', ['active', 'draft', 'archived'])->default('active');
            $table->unsignedBigInteger('reviews_count')->default(0);
            $table->float('reviews_avg')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
