<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDpcisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dpcis', function (Blueprint $table) {
            $table->id();
            $table->string('domaine_fr',200);
            $table->string('domaine_ar',200);
            $table->string('type',1);
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels');
            $table->unsignedBigInteger('dr_id')->nullable();
            $table->foreign('dr_id')->references('id')->on('drs');
            $table->unsignedBigInteger('structure_id')->nullable();
            $table->foreign('structure_id')->references('id')->on('structures');

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['domaine_fr', 'domaine_ar', 'type', 'level_id'], 'dpci_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //probably need to drop the indexes here
        Schema::dropIfExists('dpcis');
    }
}
