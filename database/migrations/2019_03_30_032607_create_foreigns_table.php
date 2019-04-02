<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('hotel_type_room', function (Blueprint $table) {
            $table->integer('type_room_id')->nullable()->unsigned();
            $table->integer('hotel_id')->nullable()->unsigned();

            $table->foreign('type_room_id')->references('id')->on('type_rooms')
                  ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('hotel_id')->references('id')->on('hotels')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('type_room_accommodation', function (Blueprint $table) {
            $table->integer('type_room_id')->nullable()->unsigned();
            $table->integer('accommodation_id')->nullable()->unsigned();

            $table->foreign('type_room_id')->references('id')->on('type_rooms')
                  ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('accommodation_id')->references('id')->on('accommodations')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}