<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAncienLogementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ancien_logements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('militaire_id');
            $table->foreign('militaire_id')
                ->references('id')
                ->on('militaires')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('emplacement_id');
            $table->foreign('emplacement_id')
                ->references('id')
                ->on('emplacements')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->foreignId('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
        //Schema::dropIfExists('ancien_logements');
        Schema::table('ancien_logements', function (Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
}
