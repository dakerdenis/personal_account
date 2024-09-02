<?php

namespace App\Repository\Eloquent;

use App\Repository\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function update(int $id, array $data): bool
    {
        $role = $this->find($id);
        if (!isset($data['permissions'])) $data['permissions'] = [];
        $role->syncPermissions($data['permissions']);
        unset($data['permissions']);
        return $role->update($data);
    }

    public function create(array $attributes): Model
    {
        $permissions = $attributes['permissions'] ?? [];
        unset($attributes['permissions']);
        $role = $this->model->create($attributes + ['guard_name' => 'staff']);
        $role->syncPermissions($permissions);
        return $role;
    }

}
