<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('categoryId');
            $table->string('name');
            $table->dateTime('modifiedOn');
            $table->string('displayName');
            $table->string('seoCategoryName');
            $table->string('sealedLabel')->nullable();
            $table->string('nonSealedLabel')->nullable();
            $table->string('conditionGuideUrl');
            $table->boolean('isScannable');
            $table->integer('popularity');
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
        Schema::dropIfExists('categories');
    }
}
