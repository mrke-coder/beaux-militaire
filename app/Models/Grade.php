<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;
    protected $table="grades";
    protected $fillable =[ 'id', 'code', 'grade', 'user_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function militaires()
    {
        return $this->belongsToMany('App\Models\Militaire')->using('App\Models\MilitaireGrade');
    }
}
