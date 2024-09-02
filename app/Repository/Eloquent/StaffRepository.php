<?php

namespace App\Repository\Eloquent;

use App\Models\Staff;
use App\Repository\StaffRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class StaffRepository extends BaseRepository implements StaffRepositoryInterface
{

    public function __construct(Staff $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $attributes): Model
    {
        $staff = Staff::create(
            [
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password']),
            ]
        );
        if (isset($attributes['roles'])) $staff->roles()->sync($attributes['roles']);
        return $staff;
    }

    public function update(int $id, array $data): bool
    {
        $staff = $this->find($id);
        $staff->name = $data['name'];
        $staff->email = $data['email'];
        if (isset($data['password']) && $data['password']) $staff->password = Hash::make($data['password']);
        if (isset($data['roles'])) $staff->roles()->sync($data['roles']);
        return $staff->save();
    }

}
