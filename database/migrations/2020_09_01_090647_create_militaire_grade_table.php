<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilitaireGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('militaire_grade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('militaire_id');
            $table->foreign('militaire_id')
                ->references('id')
                ->on('militaires')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('grade_id')
                ->references('id')
                ->on('grades')
                ->onUpdate('restrict')
                ->onDelete('restrict');
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
        //Schema::dropIfExists('militaire_grade');
        Schema::table('militaire_grade', function (Blueprint $table){
        $table->dropSoftDeletes();
    });
    }
}
