<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilitairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('militaires', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->integer('mecano')->unique();
            $table->string('situation_matrimoniale',100);
            $table->string('nom',60);
            $table->string('prenom',200);
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('adresse_email',200)->unique()->nullable();
            $table->string('contact')->unique();
            $table->string('unite_militaire');
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
        //Schema::dropIfExists('militaires');
        Schema::table('militaires', function (Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
}
