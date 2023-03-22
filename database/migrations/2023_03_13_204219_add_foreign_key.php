<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_local', function (Blueprint $table) {
            $table->foreign('type_salle_id')->references('id')->on('type_salle');
            $table->foreign('type_jour_id')->references('id')->on('type_jour');
        });
        Schema::table('gestionnaires_group_locals', function (Blueprint $table) {
            $table->foreign('group_local_id')->references('id')->on('group_local');
            $table->foreign('gestionnaire_id')->references('id')->on('gestionnaire');
        });
        Schema::table('commentaire', function (Blueprint $table) {
            $table->foreign('reservation_id')->references('id')->on('reservation');
            $table->foreign('gestionnaire_id')->references('id')->on('gestionnaire');
        });
        Schema::table('line_type_accessoire', function (Blueprint $table) {
            $table->foreign('reservation_id')->references('id')->on('reservation');
            $table->foreign('type_accessoire_id')->references('id')->on('type_accessoire');
        });
        Schema::table('group_local_local', function (Blueprint $table) {
            $table->foreign('group_local_id')->references('id')->on('group_local');
            $table->foreign('local_id')->references('id')->on('local');
        });
        Schema::table('reservation', function (Blueprint $table) {
            $table->foreign('local_id')->references('id')->on('local');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->foreign('gestionnaire_id')->references('id')->on('gestionnaire');
            $table->foreign('group_local_id')->references('id')->on('group_local');
        });
        Schema::table('gestionnaire', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('case_agenda', function (Blueprint $table) {
            $table->foreign('type_jour_id')->references('id')->on('type_jour');
        });
        Schema::table('line_local_accessoire', function (Blueprint $table) {
            $table->foreign('type_accessoire_id')->references('id')->on('type_accessoire');
            $table->foreign('local_id')->references('id')->on('local');
        });
        Schema::table('reservation_case_agenda', function (Blueprint $table) {
            $table->foreign('reservation_id')->references('id')->on('reservation');
            $table->foreign('case_agenda_id')->references('id')->on('case_agenda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
