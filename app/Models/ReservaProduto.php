<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservaProduto extends Model
{
 protected $table = 'produtos_reserva';
//  protected $dateFormat = 'd-m-Y H:i';

 protected $fillable = [
  'reserva_id', 'produto_id', 'amount',
 ];
}
