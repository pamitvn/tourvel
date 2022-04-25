<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::create('customers', function (Blueprint $table) {
         $table->id();
         $table->string('full_name', 60);
         $table->string('email', 150);
         $table->string('phone_number', 11)->unique();
         $table->timestamps();

         $table->index(['full_name', 'email', 'phone_number']);
      });
   }

   public function down()
   {
      Schema::dropIfExists('customers');
   }
};
