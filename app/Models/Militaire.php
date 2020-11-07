<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Militaire extends Model
{
    use SoftDeletes;
    protected $table ="militaires";
    protected $fillable=[
        'id',
        'mecano',
        'situation_matrimoniale',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'adresse_email',
        'contact',
        'unite_militaire',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function logement()
    {
        return $this->hasOne('App\Models\Logement');
    }

    public function grades()
    {
        return $this->belongsToMany('App\Models\Grade')->using('App\Models\MilitaireGrade');
    }

    public function ancien_logements()
    {
      return $this->hasMany('App\Models\AncienLogement');
    }

}
