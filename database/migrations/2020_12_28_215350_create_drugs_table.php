<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->double('price');
            $table->integer('count');
            $table->string('image');
            $table->boolean('famusInstance');

            $table->boolean('active')->default(0);

            $table->foreignId('status_id')
            ->constrained('status')
            ->onUpdate('cascade')
            ->onDelete('cascade');


            $table->foreignId('categories_id')
            ->constrained('categories')
            ->onUpdate('cascade')
            ->onDelete('cascade');


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
        Schema::dropIfExists('status');

        
    }
}
