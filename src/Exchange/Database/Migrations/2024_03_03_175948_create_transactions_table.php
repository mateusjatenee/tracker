<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('quantity');
            $table->string('type');
            $table->decimal('market_price_per_unit', 19, 4);
            $table->decimal('amount_paid_per_unit', 19, 4);
            $table->string('currency');
            $table->dateTime('performed_at');
            $table->foreignId('asset_id');
            $table->foreignId('position_id');
            $table->timestamps();
            $table->index(['position_id', 'performed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
