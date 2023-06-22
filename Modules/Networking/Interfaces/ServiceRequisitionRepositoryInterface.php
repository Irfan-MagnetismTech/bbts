<?php

namespace Modules\Networking\Interfaces;

interface ServiceRequisitionRepositoryInterface
{
    public function getAllServiceRequisition();
    public function getServiceRequisitionById($serviceRequisitionId);
    public function deleteServiceRequisition($serviceRequisitionId);
    public function createServiceRequisition(array $serviceRequisitionDetails);
    public function updateServiceRequisition($serviceRequisitionId, array $newDetails);
}
