<?php
 namespace App\Services;

 use App\Enums\AssetTypeEnums;
 use App\Models\AssetPrice;
 use App\Models\Gift;
 use Carbon\Carbon;

 class GiftService{

     public function index()
     {
         return Gift::latest()->get();
     }
     public function get($id)
     {
        return Gift::findOrFail($id);
     }
     public function store(array $data)
     {
         $data['date'] =  Carbon::now();
         $gift = Gift::create($data);
         //spatie media library
         if (isset($data['image'])){
             $gift->addMedia($data['image'])->toMediaCollection('gift');
         }
         return $gift;
     }
     public function update(array $data,$id)
     {
         $gift = $this->get($id);
         $gift->update($data);
         // Add the new image to the 'gift' collection
         if ($data['image']) {
             $gift->clearMediaCollection('gift');
             $gift->addMedia($data['image'])->toMediaCollection('gift');
         }
         return $gift;
     }
     public function destroy($id)
     {
         $gift = $this->get($id);
         $gift->clearMediaCollection('gift');
         $gift->delete();
         return $gift;
     }

     public function getImage($id)
     {
         $gift = $this->get($id);

         $media    = $gift->getMedia('gift')->first();
         $imageUrl = $media ? $media->getUrl() : '';

         return $imageUrl;
     }
 }
