<?php 

namespace App\Services;
use App\Enums\AssetTypeEnums;
use App\Models\AssetPrice;
use Exception;
use Illuminate\Support\Carbon;

class AssetService {

    public function goldPrice(){
        try {
            $user = auth()->user();
            $asset_price = AssetPrice::where('asset_type', AssetTypeEnums::GOLD)
            ->latest()->first();
            if($asset_price){
                return response([
                    'status' => true,
                    'date'   => Carbon::parse($asset_price->date)->format('Y-m-d h:i A'),
                    'price' => $asset_price->price,
                    'highest_price' => $asset_price->highest_price
                ]);
            }

            return response([
                'status' => false,
                'message' => 'Price not set yet. '
            ]);
        } catch (Exception $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}