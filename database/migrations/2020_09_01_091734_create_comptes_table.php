<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComptesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_compte')->nullable();
            $table->string('type_compte');
            $table->string('numero_compte');
            $table->string('nom_banque')->nullable();
            $table->foreignId('proprietaire_id');
            $table->foreign('proprietaire_id')
                ->references('id')
                ->on('proprietaires')
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
        //Schema::dropIfExists('comptes');
        Schema::table('comptes', function (Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
}
