<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::whenTableDoesntHaveColumn('tours', 'slug', function (Blueprint $table) {

         $table->string('slug', 255)->unique()->after('name');
         $table->text('policy')->nullable()->after('description');

         $table->index(['slug']);
      });
   }

   public function down()
   {
      Schema::whenTableHasColumn('tours', 'slug', function (Blueprint $table) {
         $table->dropColumn(['slug', 'policy']);
      });
   }
};
