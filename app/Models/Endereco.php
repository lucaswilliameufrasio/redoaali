<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
 /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
//  protected $dateFormat = 'Y-m-d H:i';

 protected $fillable = [
  'name_place', 'address', 'lat', 'lng', 'type', 'userowner_id',
 ];

 /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
 protected $hidden = [
  'lat', 'lng',
 ];
}
