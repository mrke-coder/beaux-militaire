<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Pivot
{
    use SoftDeletes;
    protected $table="user_role";
    protected $fillable=['user_id','role_id','created_at','updated_at'];
}
