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
            $table->dateTime('performed_at');
            $table->foreignId('account_id');
            $table->timestamps();
            $table->index(['account_id', 'performed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
