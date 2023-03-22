<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLineTypeAccessoire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_type_accessoire', function (Blueprint $table) {
            $table->id();
            $table->integer("nombre");
            $table->foreignId("reservation_id");
            $table->foreignId("type_accessoire_id");
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
        Schema::dropIfExists('line_type_accessoire');
    }
}
