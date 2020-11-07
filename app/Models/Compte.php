<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compte extends Model
{
    use SoftDeletes;
  protected $table="comptes";
  protected $fillable=['id','nom_compte','type_compte','numero_compte','nom_banque','proprietaire_id','created_at','updated_at'];

  public function proprietaire () {
      return $this->belongsTo('App\Models\Proprietaire');
  }
}
