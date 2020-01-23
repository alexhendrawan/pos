<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Laravel\Passport\HasApiTokens;
// use OwenIt\Auditing\Contracts\Auditable; 

class User extends Authenticatable
{
    use Notifiable;
    public $table = "user";
    protected $guarded = [];
       const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }
}
