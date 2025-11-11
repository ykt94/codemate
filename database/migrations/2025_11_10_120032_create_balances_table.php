<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->comment('Движение средств');
            $table->increments('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->float('amount', 2)->comment('Величина движения');
            $table->float('balance', 2)->comment('Баланс после этого движения');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
