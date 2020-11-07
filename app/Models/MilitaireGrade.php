<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilitaireGrade extends Pivot
{
    use SoftDeletes;
    protected $table="militaire_grade";
    protected $fillable =['id','militaire_id','grade_id','created_at','updated_at'];

}
