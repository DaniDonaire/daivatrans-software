<?php
namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Model;

class Role extends SpatieRole implements Auditable
{
    use AuditableTrait;

    /**
     * Sobrescribir la asignación de permisos para auditar cambios.
     */
    
}
