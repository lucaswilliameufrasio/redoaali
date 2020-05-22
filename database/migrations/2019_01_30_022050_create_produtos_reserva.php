<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosReserva extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  Schema::create('produtos_reserva', function (Blueprint $table) {
   $table->increments('id');
   $table->integer('reserva_id')->unsigned()->nullable();
   $table->foreign('reserva_id')->references('id')->on('reservas')
    ->onUpdate('cascade')->onDelete('set null');
   $table->integer('produto_id')->unsigned()->nullable();
   $table->foreign('produto_id')->references('id')->on('produtos')
    ->onUpdate('cascade')->onDelete('set null');
   $table->integer('amount')->unsigned();
   $table->timestamps();
  });
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down()
 {
  Schema::dropIfExists('produtos_reserva');
 }
}
