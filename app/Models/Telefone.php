<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{

 /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
//  protected $dateFormat = 'Y-m-d H:i';

 protected $fillable = [
  'numero', 'userowner_id', 'tipo',
 ];

}
