<?php

namespace App\Models;

use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    public static function getPermissionsWithModule()
    {
        $query = parent::all();
        $result = [];

        foreach ($query as $permission) {
            $result[$permission->module][] = new PermissionResource($permission);
        }

        return $result;
    }
}
