<?php

namespace Modules\Networking\Repositories;

use Modules\Networking\Entities\NetServiceRequisition;
use Modules\Networking\Interfaces\ServiceRequisitionRepositoryInterface;

class ServiceRequisitionRepository implements ServiceRequisitionRepositoryInterface
{
    public function getAllServiceRequisition()
    {
        return NetServiceRequisition::all();
    }
    public function getServiceRequisitionById($serviceRequisitionId)
    {
        return NetServiceRequisition::findOrFail($serviceRequisitionId);
    }
    public function deleteServiceRequisition($serviceRequisitionId)
    {
        NetServiceRequisition::destroy($serviceRequisitionId);
    }
    public function createServiceRequisition(array $taskDetails)
    {
        return NetServiceRequisition::create($taskDetails);
    }
    public function updateServiceRequisition($serviceRequisitionId, array $newDetails)
    {
        return NetServiceRequisition::whereId($serviceRequisitionId)->update($newDetails);
    }
}
