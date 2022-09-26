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

        Schema::create('servicestypes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->timestamps();
        });
        
        
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('image');
            $table->double('price');
            $table->string('time_service');
            $table->boolean('active')->nullable()->default(true);

            $table->foreignId('servicetype_id')
            ->constrained('servicestypes')
            ->onUpdate('cascade')
            ->onDelete('cascade');


            $table->foreignId('salons_id')
            ->constrained('salons')
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
        Schema::dropIfExists('services');
        Schema::dropIfExists('servicestypes');

        
    }
}
