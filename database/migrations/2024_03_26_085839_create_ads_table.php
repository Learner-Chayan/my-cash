<?php


use App\Enums\AdsAdminApprovalEnums;
use App\Enums\AdsTypeEnums;
use App\Enums\PriceTypeEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\DeleteStatusEnums;
use App\Enums\PermissionStatusEnums;
use App\Enums\VisibilityStatusEnums;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
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
            $table->double("order_limit_min",16,6);
            $table->double("order_limit_max",16,6);
            $table->unsignedTinyInteger("delete_status")->default(DeleteStatusEnums::NOT_DELETED)->comment(DeleteStatusEnums::DELETED."= Deleted , ".DeleteStatusEnums::NOT_DELETED."= Not Delete");
            $table->unsignedTinyInteger("permission_status")->default(PermissionStatusEnums::PENDING)->comment(PermissionStatusEnums::APPROVED."= Approved , ".PermissionStatusEnums::PENDING."= Pending");
            $table->unsignedTinyInteger("visibility_status")->default(VisibilityStatusEnums::ENABLE)->comment(VisibilityStatusEnums::ENABLE."= Enable , ".VisibilityStatusEnums::DISABLE."= Disable");
            $table->dateTime('date');
            $table->unsignedTinyInteger('admin_status')->comment(AdsAdminApprovalEnums::APPROVED."= approved , ".AdsAdminApprovalEnums::CHECKING ."= checking ");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
