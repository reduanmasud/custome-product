<?php

namespace App\Models\Audit;

use Spatie\Permission\Models\Role as SpatieRole;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Role extends SpatieRole implements Auditable
{
    use AuditableTrait;

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'name',
        'guard_name',
    ];

    /**
     * Audit event names to record
     *
     * @var array
     */
    protected $auditEvents = [
        'created',
        'updated',
        'deleted',
    ];

    /**
     * User responsible for the changes
     *
     * @return mixed
     */
    public function resolveUser()
    {
        return auth()->user();
    }
}
