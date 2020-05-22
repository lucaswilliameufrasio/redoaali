<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  Schema::create('users', function (Blueprint $table) {
   $table->increments('id');
   $table->string('business_name');
   $table->string('representative_name');
   $table->integer('permission_access');
   $table->integer('status');
   $table->string('cnpj')->unique();
   $table->string('email')->unique();
   $table->timestamp('email_verified_at')->nullable();
   $table->string('password');
   $table->rememberToken();
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
  Schema::dropIfExists('users');
 }
}
