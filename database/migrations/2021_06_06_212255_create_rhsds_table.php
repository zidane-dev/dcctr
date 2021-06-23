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

                $table->decimal('ANNEE',4,0);
                $table->decimal('OBJECTIF',6,0);
                $table->decimal('REALISATION',6,0);
                $table->decimal('ECART',6,0);
                $table->tinyInteger('ETAT');
                $table->tinyInteger('REJET');

                $table->unsignedBigInteger('id_user');
                $table->foreign('id_user')->references('id')->on('users');
                $table->text("Description")->nullable();
                $table->text("Motif")->nullable();
                $table->softDeletes();
                $table->timestamps();

            $table->index(['id_qualite', 'id_domaine', 'ANNEE', 'OBJECTIF'], 'rhsd_unique');

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
