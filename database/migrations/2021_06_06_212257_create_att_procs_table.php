<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttProcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('att_procs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_axe')->default(1);
            $table->foreign('id_axe')->references('id')->on('axes');
            $table->unsignedBigInteger('id_attribution');
            $table->foreign('id_attribution')->references('id')->on('attributions');
            $table->unsignedBigInteger('id_domaine');
            $table->foreign('id_domaine')->references('id')->on('dpcis');
            $table->unsignedBigInteger('id_action');
            $table->foreign('id_action')->references('id')->on('actions');
            $table->unsignedBigInteger('id_level');
            $table->foreign('id_level')->references('id')->on('levels');
            
            $table->decimal('ANNEEOBJ',4,0);
            $table->decimal('ANNEERLS',4,0);

            $table->boolean('STATUT')->default(0);
            $table->tinyInteger('ETAT');
            $table->tinyInteger('REJET');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['id_axe', 'id_attribution', 'id_domaine', 'id_action', 'id_level', 'ANNEEOBJ'], 'attproc_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('att_procs');
    }
}
