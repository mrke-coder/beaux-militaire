<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','firstName','lastName','avatar','username','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'username_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role')->using('App\UserRole');
    }

    public function ancien_logements()
    {
        return $this->hasMany('App\Models\AncienLogement');
    }

    public function emplacements()
    {
        return $this->hasMany('App\Models\Emplacement');
    }

    public function grades()
    {
        return $this->hasMany('App\Models\Grade');
    }

    public function logements()
    {
        return $this->hasMany('App\Models\Logement');
    }

    public function militaires()
    {
       return $this->hasMany('App\Models\Militaire');
    }

    public function proprietaires()
    {
        return $this->hasMany('App\Models\Proprietaire');
    }

    public function type_logements()
    {
      return $this->hasMany('App\Models\TypeLogement');
    }
}
