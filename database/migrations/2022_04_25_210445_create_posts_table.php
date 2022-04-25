<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      Schema::create('posts', function (Blueprint $table) {
         $table->id();
         $table->string('title', 255);
         $table->string('slug', 255)->unique();
         $table->text('content')->nullable();
         $table->string('feature_image', 255)->nullable();

         $table->string('seo_title', 255)->nullable();
         $table->text('seo_description')->nullable();
         $table->string('seo_image', 255)->nullable();

         $table->timestamps();

         $table->index(['title', 'slug']);
      });
   }

   public function down()
   {
      Schema::dropIfExists('posts');
   }
};
