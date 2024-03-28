<?php
 namespace App\Services;

 use App\Enums\AssetTypeEnums;
 use App\Models\AssetPrice;
 use Carbon\Carbon;

 class AssetPriceService{

     public function index()
     {
         return AssetPrice::latest()->get();
     }
     public function get($id)
     {
        return AssetPrice::findOrFail($id);
     }
     public function store(array $data)
     {
         $data['asset_type'] = AssetTypeEnums::GOLD;
         $data['date'] =  Carbon::now();
         $price = AssetPrice::create($data);
         return $price;
     }
     public function update(array $data,$id)
     {
         $assetPrice = $this->get($id);
         $assetPrice->update($data);
         return $assetPrice;
     }
     public function destroy($id)
     {
         $assetPrice = $this->get($id);
         $assetPrice->delete();
         return $assetPrice;
     }
 }
