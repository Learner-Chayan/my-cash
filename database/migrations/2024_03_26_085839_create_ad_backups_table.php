<?php


use App\Enums\AdsTypeEnums;
use App\Enums\PriceTypeEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ad_backups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('ads_unique_num',20)->unique();
            $table->unsignedTinyInteger('ad_type')->comment(AdsTypeEnums::BUY."= buy , ".AdsTypeEnums::SELL."= Sell");
            $table->unsignedTinyInteger('asset_type');
            $table->double('unit_price', 16,6);
            $table->double('highest_price', 16,6);
            $table->double('sell_price', 16,6);
            $table->unsignedTinyInteger('price_type')->default(PriceTypeEnums::FIXED)->comment(PriceTypeEnums::FIXED."= Fixed , ".PriceTypeEnums::FLOATING."= Floating");
            $table->double("total_amount",16,6);
            $table->unsignedTinyInteger('status')->comment(Status::ACTIVE."= Active , ".Status::INACTIVE."= Inactive");
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_backups');
    }
};
