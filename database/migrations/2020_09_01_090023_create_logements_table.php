<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logements', function (Blueprint $table) {
            $table->id();
            $table->string('numero_lot');
            $table->string('numero_ilot');
            $table->integer('nombre_piece');
            $table->foreignId('emplacement_id');
            $table->foreign('emplacement_id')
                ->references('id')
                ->on('emplacements')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreignId('type_logement_id');
            $table->foreign('type_logement_id')
                ->references('id')
                ->on('type_logements')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('proprietaire_id');
            $table->foreign('proprietaire_id')
                ->references('id')
                ->on('proprietaires')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('militaire_id');
            $table->foreign('militaire_id')
                ->references('id')->on('militaires')
                ->onDelete('restrict')->onUpdate('restrict');
            $table->softDeletes();
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
       // Schema::dropIfExists('logements');
        Schema::table('logements', function (Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
}
