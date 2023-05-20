<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->bigInteger('id_cate');
            $table->bigInteger('id_form');
            $table->integer('type_price');
            $table->integer('class');
            $table->string('name');
            $table->string('description');
            $table->decimal('price',8,0);
            $table->bigInteger('total_number');
            $table->integer('numberone');
            $table->integer('numbertwo');
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
