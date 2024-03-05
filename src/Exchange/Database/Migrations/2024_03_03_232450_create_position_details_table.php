<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('position_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('quantity');
            $table->decimal('average_price', 19, 4);
            $table->decimal('current_market_price', 19, 4);
            $table->integer('profit');
            $table->string('currency');
            $table->dateTime('calculated_at');
            $table->foreignId('position_id')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('position_details');
    }
};
