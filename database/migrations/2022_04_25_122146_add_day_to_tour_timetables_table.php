<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::whenTableDoesntHaveColumn('tour_timetables', 'day', function (Blueprint $table) {
         $table->string('day', 50)->after('tour_id');
      });
   }

   public function down()
   {
      Schema::whenTableHasColumn('tour_timetables', 'day', function (Blueprint $table) {
         $table->dropColumn('day');
      });
   }
};
