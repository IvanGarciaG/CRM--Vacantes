<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug'];
    protected $useTimestamps    = false;

    public const ADMIN                = 1;
    public const ADMIN_OPERATIVO      = 2;
    public const OPERATIVO            = 3;
}
