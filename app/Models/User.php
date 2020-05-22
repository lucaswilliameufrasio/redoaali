<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
 use Notifiable;

//  protected $dateFormat = 'Y-m-d H:i';

 /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
 protected $fillable = [
  'business_name', 'email', 'password', 'permission_access', 'representative_name', 'cnpj', 'status',
 ];

 /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
 protected $hidden = [
  'password', 'remember_token', 'permission_access',
 ];
}
