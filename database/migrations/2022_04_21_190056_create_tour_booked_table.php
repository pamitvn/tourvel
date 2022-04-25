<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tour_booked', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();
            $table->foreignId('tour_property_id')
                ->constrained('tour_properties')
                ->cascadeOnDelete();
            $table->json('amounts')->nullable();
            $table->integer('total_price');
            $table->text('note')->nullable();
            $table->date('started_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_booked');
    }
};
