<?php


namespace App\Observers;

use Spatie\Permission\Models\Role;
use OwenIt\Auditing\Facades\Auditor;

class RoleObserver
{

    public function created(Role $role)
    {
        Auditor::execute($role);
    }

    public function updated(Role $role)
    {
        Auditor::execute($role);
    }

    public function deleted(Role $role)
    {
        Auditor::execute($role);
    }
    

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
