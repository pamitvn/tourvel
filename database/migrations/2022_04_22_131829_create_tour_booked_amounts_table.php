<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tour_booked_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booked_id')
                ->constrained('tour_booked')
                ->cascadeOnDelete();
            $table->foreignId('property_price_id')
                ->constrained('tour_property_prices')
                ->cascadeOnDelete();
            $table->integer('amount')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_booked_amounts');
    }
};
