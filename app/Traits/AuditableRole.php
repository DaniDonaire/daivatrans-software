<?php
namespace App\Traits;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

trait AuditableRole
{
    use AuditableTrait;

    // Definir los eventos de auditoría permitidos
    public function getAuditEvent()
    {
        return $this->auditEvent ?? ['created', 'updated', 'deleted'];
    }
}
