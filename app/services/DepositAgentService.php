<?php
namespace App\Services;

use App\Models\DepositAgent;

class DepositAgentService
{

    public function agentList()
    {
        return DepositAgent::latest()->get();
    }

    public function agentGet($id)
    {
        return DepositAgent::findOrFail($id);
    }
    public function store(array $data)
    {
        return DepositAgent::create($data);
    }
    public function update(array $data,$id)
    {
        $agent = $this->agentGet($id);
        $agent->update($data);
        return $agent;
    }
    public function delete($id)
    {
        $agent = $this->agentGet($id);
        $agent->delete();
        return 0;
    }


}
