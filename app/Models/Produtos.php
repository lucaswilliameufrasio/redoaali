<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
 protected $fillable = [
  'name_product', 'amount', 'userowner_id', 'id_local', 'datadisponivel', 'horarioinicial', 'horariofinal',
 ];

//  protected $hidden     = ['id'];
 //  protected $dateFormat = 'Y-m-d H:i';

}
