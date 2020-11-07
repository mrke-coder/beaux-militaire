<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeLogement extends Model
{
    use SoftDeletes;
    protected $table="type_logements";
    protected $fillable=['id','description','user_id','created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function logements()
    {
        return $this->hasMany('App\Models\Logement');
    }
}
