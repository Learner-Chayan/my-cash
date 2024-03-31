<?php

namespace App\Services;


use App\Enums\AdsAdminApprovalEnums;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdsApprovalService
{

    public function index()
    {
        return Ad::with('user')->orderBy('admin_status','asc')->get();
    }
    public function get($id)
    {
        return Ad::with('user')->findOrFail($id);
    }
    public function changeStatus($id)
    {
        $ad = $this->get($id);
        if ($ad->admin_status === AdsAdminApprovalEnums::APPROVED){

            $ad->admin_status = AdsAdminApprovalEnums::CHECKING;
            $ad->save();

        }else{

            $ad->admin_status = AdsAdminApprovalEnums::APPROVED;
            $ad->save();
        }
        return $ad;
    }


}
