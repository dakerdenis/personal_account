<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $user = parent::create($attributes);
        $this->handleMedia($user, $attributes);

        return $user;
    }

    public function update(int $id, array $data): bool
    {
        $newPassword = $data['password'] ?? null;
        unset($data['password']);
        if ($newPassword) {
            $data['password'] = Hash::make($newPassword);
        }
        $data['phone'] = (int)filter_var($data['phone'], FILTER_SANITIZE_NUMBER_INT);
        $user = $this->find($id);

        return $user->update($data);
    }

    public function delete(int $id): ?bool
    {
        $user = $this->find($id);
        $user->adverts()->delete();
        return $user->delete();
    }
}
