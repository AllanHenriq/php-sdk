<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('productId');
            $table->string('name')->nullable();
            $table->string('cleanName')->nullable();
            $table->string('imageUrl')->nullable();
            $table->integer('categoryId');
            $table->integer('groupId');
            $table->string('url', 4096);
            $table->dateTime('modifiedOn');
            $table->json('extendedData')->nullable();
            $table->json('presaleInfo')->nullable();
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
}
