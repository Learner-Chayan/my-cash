<?php
namespace App\Services;


use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\User;

class UserService
{

    public function getUser($data)
    {
        return User::select('id','name','phone','email','pay_id')->where($data['type'],$data['value'])->first();
    }

}
?>
