<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('salons_services', function (Blueprint $table) {
            $table->id();
            $table->double('price');
            // $table->double('price');
            $table->string('time_service');
            $table->foreignId('service_id')
            ->constrained('services')
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
        Schema::dropIfExists('salons_services');
    }
}
