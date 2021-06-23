<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_depense');
            $table->foreign('id_depense')->references('id')->on('depenses');

            $table->unsignedBigInteger('id_domaine');
            $table->foreign('id_domaine')->references('id')->on('dpcis');

            $table->unsignedBigInteger('id_axe');
            $table->foreign('id_axe')->references('id')->on('axes');

            $table->decimal('ANNEE',4,0);
            $table->decimal('OBJECTIF',12,0);
            $table->decimal('REALISATION',12,0);
            $table->decimal('ECART',12,0);
            $table->tinyInteger('ETAT');
            $table->tinyInteger('REJET');

            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->text("Description")->nullable();
            $table->text("Motif")->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['id_depense', 'id_domaine', 'ANNEE', 'OBJECTIF'], 'budget_unique');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}
