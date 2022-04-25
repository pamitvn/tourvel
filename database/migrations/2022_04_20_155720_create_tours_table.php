<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->index()
                ->constrained('tour_categories')
                ->cascadeOnDelete();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->timestamps();

           $table->index(['name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tours');
    }
};
