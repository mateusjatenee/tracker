<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->decimal('quantity', 19, 4);
            $table->unsignedInteger('average_price');
            $table->unsignedInteger('current_market_price');
            $table->integer('profit');
            $table->string('currency');
            $table->dateTime('calculated_at');
            $table->foreignId('asset_id');
            $table->foreignId('account_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
