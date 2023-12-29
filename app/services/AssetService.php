<?php
namespace App\Services;


use App\Enums\AssetStatus;
use App\Models\Asset;

class AssetService{


    public function index()
    {
        return Asset::latest()->get();
    }
    public function getUnlock()
    {
        return Asset::where('status',AssetStatus::UNLOCK)->get();
    }
    public function getLock()
    {
        return Asset::where('status',AssetStatus::LOCK)->get();
    }
    public function getAsset($id)
    {
        return Asset::findOrFail($id);
    }
    public function store(array $data)
    {
        return Asset::create($data);
    }

    public function update(array $data,$id)
    {
        $asset = $this->getAsset($id);
        return $asset->fill($data)->save();
    }
    public function destroy($id)
    {
        $asset = $this->getAsset($id);
        $asset->status = AssetStatus::DELETE;
        $asset->save();
        return $asset;
    }

}
?>
