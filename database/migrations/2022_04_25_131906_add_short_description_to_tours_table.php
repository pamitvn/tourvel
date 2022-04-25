<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::whenTableDoesntHaveColumn('tours', 'short_description', function (Blueprint $table) {
         $table->text('short_description')->nullable()->after('description');
      });
   }

   public function down()
   {
      Schema::whenTableHasColumn('tours', 'short_description', function (Blueprint $table) {
         $table->dropColumn('short_description');
      });
   }
};
