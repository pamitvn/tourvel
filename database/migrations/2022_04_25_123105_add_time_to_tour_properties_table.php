<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::whenTableDoesntHaveColumn('tour_properties', 'time', function (Blueprint $table) {
         $table->string('time', 50)->after('tour_id');
      });
   }

   public function down()
   {
      Schema::whenTableHasColumn('tour_properties', 'time', function (Blueprint $table) {
         $table->dropColumn('time');
      });
   }
};
