<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableModification01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_local', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_jour_id');
            //$table->integer('type_jour_id');
            //$table->dropForeign('type_jour_id')->references('id')->on('type_jour');
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
