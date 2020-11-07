<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proprietaire extends Model
{
    use SoftDeletes;
    protected $table="proprietaires";
    protected $fillable=['id','civilite','nom','prenoms','email','contact','user_id','created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comptes()
    {
        return $this->hasMany('App\Models\Compte');
    }

    public function logements()
    {
        return $this->hasMany('App\Models\Logements');
    }
}
