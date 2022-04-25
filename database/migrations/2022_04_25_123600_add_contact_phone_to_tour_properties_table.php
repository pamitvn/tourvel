<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::whenTableDoesntHaveColumn('tour_properties', 'contact_phone', function (Blueprint $table) {
         $table->string('contact_phone', 11)->nullable()->after('tour_id');
      });
   }

   public function down()
   {
      Schema::whenTableHasColumn('tour_properties', 'contact_phone', function (Blueprint $table) {
         $table->dropColumn('contact_phone');
      });
   }
};
