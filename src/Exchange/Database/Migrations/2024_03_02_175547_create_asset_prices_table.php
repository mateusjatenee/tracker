<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->index();
            $table->decimal('price', 19, 8);
            $table->string('currency');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_prices');
    }
};
