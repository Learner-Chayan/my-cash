<?php

use App\Enums\Status;
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
        Schema::create('ad_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained('ads');
            $table->foreignId('sell_by')->constrained('users');
            $table->foreignId('purchase_by')->constrained('users');
            $table->double('quantity', 16,6);
            $table->double('amount', 16,6);
            $table->string('add_trans_id', 20);
            $table->string('method')->default("Halal Pay");
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_transactions');
    }
};
