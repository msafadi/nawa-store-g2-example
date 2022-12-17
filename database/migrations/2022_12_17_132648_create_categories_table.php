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
        Schema::create('categories', function (Blueprint $table) {
            // `id` BIGINT UNSIGED NOT NULL AUTO_INCERMENT PRIMARY
            // $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            // $table->unsignedBigInteger('id')->autoIncrement()->primary();
            // $table->bigIncrements('id')->primary();
            $table->id();

            // `name` VARCHAR(255) NOT NULL
            $table->string('name');
            // `image_path` VARCHAR(500) NULL
            $table->string('image_path', 500)->nullable();

            // `parent_id` BIGINT UNSIGNED NULL
            $table->unsignedBigInteger('parent_id')->nullable();

            // `slug` VARCHAR(255) NOT NULL + UNIQUE Index
            $table->string('slug')->unique();

            // `created_at` TIMESTAMP NULL
            // `updated_at  TIMESTAMP NULL
            $table->timestamps();

            // Add Foreign key (parent_id)
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('categories')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
