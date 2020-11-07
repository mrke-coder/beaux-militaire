<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AncienLogement extends Model
{
    use SoftDeletes;
    protected $table="ancien_logements";
    protected $fillable=['id','militaire_id','emplacement_id','date_debut','date_fin','user_id','created_at','updated_at'];

    public function user()
    {
       return $this->belongsTo('App\User');
    }

    public function emplacement()
    {
      return $this->belongsTo('App\Models\Emplacement');
    }

    public function militaire()
    {
        return $this->belongsTo('App\Models\Militaire');
    }
}
