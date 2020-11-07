<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
   protected $table="roles";
   protected $fillable=['id','role','description','created_at','updated_at'];

    public function users()
    {
       return $this->belongsToMany('App\User')->using('App\UserRole');
   }
}
