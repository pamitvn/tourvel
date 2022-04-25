<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::whenTableDoesntHaveColumn('tours', 'location', function (Blueprint $table) {
         $table->json('location')->after('cover_image')->nullable();
      });
   }

   public function down()
   {
      Schema::whenTableHasColumn('tours', 'location', function (Blueprint $table) {
         $table->dropColumn('location');
      });
   }
};
