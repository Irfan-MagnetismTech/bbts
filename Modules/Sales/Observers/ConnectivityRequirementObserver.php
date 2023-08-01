<?php

namespace Modules\Sales\Observers;

use Modules\Sales\Entities\ConnectivityRequirement;

class ConnectivityRequirementObserver
{
    /**
     * Handle the ConnectivityRequirement "created" event.
     *
     * @param  \App\Models\ConnectivityRequirement  $connectivityRequirement
     * @return void
     */
    public function created(ConnectivityRequirement $connectivityRequirement)
    {
        //
    }

    /**
     * Handle the ConnectivityRequirement "updated" event.
     *
     * @param  \App\Models\ConnectivityRequirement  $connectivityRequirement
     * @return void
     */
    public function updated(ConnectivityRequirement $connectivityRequirement)
    {
        $changes = $connectivityRequirement->getDirty();
    }

    /**
     * Handle the ConnectivityRequirement "deleted" event.
     *
     * @param  \App\Models\ConnectivityRequirement  $connectivityRequirement
     * @return void
     */
    public function deleted(ConnectivityRequirement $connectivityRequirement)
    {
        //
    }

    /**
     * Handle the ConnectivityRequirement "restored" event.
     *
     * @param  \App\Models\ConnectivityRequirement  $connectivityRequirement
     * @return void
     */
    public function restored(ConnectivityRequirement $connectivityRequirement)
    {
        //
    }

    /**
     * Handle the ConnectivityRequirement "force deleted" event.
     *
     * @param  \App\Models\ConnectivityRequirement  $connectivityRequirement
     * @return void
     */
    public function forceDeleted(ConnectivityRequirement $connectivityRequirement)
    {
        //
    }
}
