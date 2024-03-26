<?php
namespace App\Services;


use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\User;

class CustomerService
{

    public function getCustomer($type)
    {
        return User::role($type)->latest()->get();
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

}
?>
