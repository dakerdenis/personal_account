<?php

namespace App\Http\Controllers\Backend\Roles;

use App\Helpers\Loggable;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\RoleDataRequest;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\PermissionRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends BackendController
{
    public function __construct(
        private RoleRepositoryInterface       $roleRepository,
        private ActivityRepositoryInterface   $activityRepository,
        private PermissionRepositoryInterface $permissionRepository,
    )
    {
        $this->middleware(['permission:manage roles']);
    }

    public function index(Request $request): View
    {
        $roles = $this->roleRepository->filterAndPaginate($request, 12);
        return $this->render('backend.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $role_permissions = [];
        $all_permissions = $this->permissionRepository->all();
        return $this->render('backend.roles.create', compact('role_permissions', 'all_permissions'));
    }

    public function store(RoleDataRequest $request): RedirectResponse
    {
        if ($role = $this->roleRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Role has been created successfully'];
            $this->activityRepository->log('content', $role, ['route_name' => 'backend.roles.edit', 'parameter' => 'role', 'title' => $role->name], Loggable::$created);
        }
        return redirect()->route('backend.roles.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(Request $request, Role $role): View
    {
        $role_permissions = $role->permissions()->select('id')->get()->pluck('id')->toArray();
        $all_permissions = $this->permissionRepository->all();
        return $this->render('backend.roles.create', compact('role', 'role_permissions', 'all_permissions'));
    }

    public function update(RoleDataRequest $request, Role $role): RedirectResponse
    {
        $data = $request->validated();
        if ($this->roleRepository->update($role->id, $data)) {
            $message = ['type' => 'Success', 'message' => 'Role has been updated successfully'];
            $this->activityRepository->log('content', $role, ['route_name' => 'backend.roles.edit', 'parameter' => 'role', 'title' => $role->name], Loggable::$updated);
        }
        return redirect()->route('backend.roles.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(Role $role): RedirectResponse
    {
        abort(403);
        $title = $role->name;
        if ($this->roleRepository->delete($role->id)) {
            $message = ['type' => 'Success', 'message' => 'Role has been deleted successfully'];
            $this->activityRepository->log('content', $role, ['title' => $title], Loggable::$deleted);
        }
        return redirect()->route('backend.roles.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function clearCache(Request $request): RedirectResponse
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        return redirect()->route('backend.roles.index')->with('message', ['type' => 'Success', 'message' => 'Cache cleared']);
    }

}
