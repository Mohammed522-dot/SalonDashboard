<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->integer('amount');

            $table->string('note')->nullable();
            $table->string('address')->nullable();
            $table->string('booking_dates')->nullable();
            $table->string('time')->nullable();


            $table->foreignId('user_id')
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');


            $table->integer('status_id')->default(0);

            $table->string('updated_by')->nullable();

            $table->foreignId('salon_id')
            ->constrained('salons')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->timestamps();
        });


        Schema::create('bookings_services', function (Blueprint $table) {
            $table->id();
            $table->double('invoice');

            $table->foreignId('service_id')
            ->constrained('services')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('booking_id')
            ->constrained('bookings')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->integer('status')->default(0);

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
        Schema::dropIfExists('bookings');
    }
}
