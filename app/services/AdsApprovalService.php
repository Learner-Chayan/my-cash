<?php

namespace App\Services;


use App\Enums\PermissionStatusEnums;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdsApprovalService
{

    public function index()
    {
        return Ad::with('user')->orderBy('permission_status','asc')->get();
    }
    public function get($id)
    {
        return Ad::with('user')->findOrFail($id);
    }
    public function changeStatus($id)
    {
        $ad = $this->get($id);
        if ($ad->permission_status === PermissionStatusEnums::APPROVED){

            $ad->permission_status = PermissionStatusEnums::CHECKING;
            $ad->save();

        }else{

            $ad->permission_status = PermissionStatusEnums::APPROVED;
            $ad->save();
        }
        return $ad;
    }


}
