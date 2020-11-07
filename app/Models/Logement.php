<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logement extends Model
{
    use SoftDeletes;
    protected $table="logements";
    protected $fillable=[
        'id',
        'numero_lot',
        'numero_ilot',
        'nombre_piece',
        'emplacement_id',
        'type_logement_id',
        'proprietaire_id',
        'militaire_id',
        'user_id', 'created_at', 'updated_at'];

    public function emplacement()
    {
        return $this->belongsTo('App\Models\Emplacement');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function proprietaire()
    {
        return $this->belongsTo('App\Models\Proprietaire');
    }

    public function type_logement()
    {
        return $this->belongsTo('App\Models\TypeLogement');
    }

    public function militaire()
    {
        return $this->belongsTo('App\Models\Militaire');
    }
}
