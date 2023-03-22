<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->string("libelle");
            $table->string("start");
            $table->string("end");
            $table->string("status");
            $table->dateTime("date_reservation");
            $table->foreignId("user_id");
            $table->foreignId("local_id");
            $table->foreignId("group_local_id");
            $table->foreignId("gestionnaire_id")->nullable(true);
            $table->foreignId("periode_id")->nullable(true);
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
        Schema::dropIfExists('reservation');
    }
}
