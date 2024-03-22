<?php
namespace App\Services;


use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\User;

class UserService
{

    public function getUser($data)
    {
        $user = User::select('id','name',$data['type'],'pay_id')->where($data['type'],$data['value'])->first();

        if ($user){

            if($user->id === auth()->user()->id){
                return ['status' => false,'message' => 'Self to self transaction is not possible'];
            }

            return ['status' => true,'message' => 'Successfully Get User','data' => $user];
        }else{
            return ['status' => false,'message' => 'Not Found'];

        }
    }
    public function getPayIdUser($data)
    {
//        return $data;
        $user = User::where('pay_id','=',$data)->first();
        if ($user){
            return ['status' => true,'message' => 'Successfully Get User','data' => $user];
        }else{
            return ['status' => false,'message' => 'Not Found'];

        }
    }

}
?>
