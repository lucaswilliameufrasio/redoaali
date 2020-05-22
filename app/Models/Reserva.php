<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
 protected $table = 'reservas';
//  protected $dateFormat = 'Y-m-d H:i';
 protected $fillable = [
  'user_id', 'business_name', 'representative_name', 'email',
  'cnpj', 'telefone', 'celular',
 ];
}
