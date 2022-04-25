<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::create('sliders', function (Blueprint $table) {
         $table->id();
         $table->string('cover_image', 255)->index();
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('sliders');
   }
};
