<?php
namespace App\Services;


use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\User;
use http\Exception\InvalidArgumentException;

class CustomerService
{

    public function getCustomer($type)
    {
        return User::role($type)->latest()->get();
    }

    public function getCustomerAgent()
    {
        return User::role(['regular','agent'])->whereIn('is_authenticated',[0,1])->latest()->get();
    }

    public function getSingle($id)
    {
        return User::findOrFail($id);
    }

    public function update(array $data,$id)
    {
        $user = $this->getSingle($id); // get the user from request id
        $user->update($data);//update user with data

        // assign or remove role
        $roleId = $data['roles'];
        $user->roles()->sync($roleId ?? []);
        return $user;

    }

    public function updateVerification($id)
    {
        $customer = $this->getSingle($id);
        $customer->is_authenticated = $customer->is_authenticated == 1 ? 0 : 1;
        $customer->save();
        return $customer;
    }

}
?>
