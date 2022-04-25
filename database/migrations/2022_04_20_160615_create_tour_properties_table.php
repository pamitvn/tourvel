<?php

use App\Enums\TourStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tour_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')
                ->index()
                ->constrained('tours')
                ->cascadeOnDelete();
            $table->date('started_date')->nullable();
            $table->string('vehicle', 100)->nullable();
            $table->integer('amount')->default(0);
            $table->integer('status')->default('3');
            $table->timestamps();

           $table->index(['status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_properties');
    }
};
