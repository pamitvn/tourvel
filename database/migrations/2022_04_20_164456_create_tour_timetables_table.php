<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tour_timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')
                ->index()
                ->constrained('tours')
                ->cascadeOnDelete();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->timestamps();

           $table->index(['name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_timetables');
    }
};
