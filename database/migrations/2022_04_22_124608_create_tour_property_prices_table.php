<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tour_property_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')
                ->index()
                ->constrained('tour_properties')
                ->cascadeOnDelete();
            $table->string('name', 50);
            $table->integer('price')->default(0);
            $table->timestamps();

           $table->index(['name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_property_prices');
    }
};
