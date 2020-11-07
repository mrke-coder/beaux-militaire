<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emplacement extends Model
{
    use SoftDeletes;
    protected $table ="emplacements";
    protected $fillable=[ 'id', 'ville', 'commune', 'quartier', 'user_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function logements()
    {
        return $this->hasMany('App\Models\Logement');
    }

    public function ancien_logements()
    {
        return $this->hasMany('App\Models\AncienLogement');
    }
}
