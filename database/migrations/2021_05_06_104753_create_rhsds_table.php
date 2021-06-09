<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRhsdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('rhsds')){
            Schema::create('rhsds', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_qualite');
                $table->foreign('id_qualite')->references('id')->on('qualites');

                $table->unsignedBigInteger('id_domaine');
                $table->foreign('id_domaine')->references('id')->on('dpcis');

                $table->unsignedBigInteger('id_axe');
                $table->foreign('id_axe')->references('id')->on('axes');

                $table->decimal('ANNEESD',4,0);
                $table->date('DATESD')->nullable();
                $table->decimal('OBJECTIFSD',6,0);
                $table->decimal('REALISATIONSD',6,0);
                $table->decimal('ECARTSD',6,0);
                $table->tinyInteger('ETATSD')->comment('1 => active 0=> inactive');
                $table->tinyInteger('REJETSD')->comment('1 => Rejet 0=> non Rejet');

                $table->unsignedBigInteger('id_user');
                $table->foreign('id_user')->references('id')->on('users');
                $table->text("Description")->nullable();
                $table->text("Motif")->nullable();
                $table->softDeletes();
                $table->timestamps();

            $table->unique(['id_qualite', 'id_domaine', 'ANNEESD'], 'rhsd_unique');

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //probably need to drop the indexes here
        Schema::dropIfExists('rhsds');
    }
}
