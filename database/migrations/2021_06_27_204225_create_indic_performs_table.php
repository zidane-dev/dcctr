<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicPerformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indic_performs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_unite');
            $table->foreign('id_unite')->references('id')->on('unites');
            $table->unsignedBigInteger('id_indicateur');
            $table->foreign('id_indicateur')->references('id')->on('indicateurs');
            $table->unsignedBigInteger('id_objectif');
            $table->foreign('id_objectif')->references('id')->on('objectifs');
            $table->unsignedBigInteger('id_domaine');
            $table->foreign('id_domaine')->references('id')->on('dpcis');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->unsignedBigInteger('id_axe');
            $table->foreign('id_axe')->references('id')->on('axes');

            $table->decimal('ANNEE',4,0);
            $table->decimal('OBJECTIF',12,0);
            $table->decimal('REALISATION',12,0);
            $table->decimal('ECART',12,0);
            $table->tinyInteger('ETAT');
            $table->tinyInteger('REJET');

            $table->text("Description")->nullable();
            $table->text("Motif")->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['id_unite', 'id_objectif', 'id_indicateur', 'id_domaine', 'ANNEE', 'OBJECTIF'], 'budget_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indic_performs');
    }
}
