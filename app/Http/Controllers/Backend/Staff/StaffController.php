<?php

namespace App\Http\Controllers\Backend\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StaffDataRequest;
use App\Models\Staff;
use App\Repository\RoleRepositoryInterface;
use App\Repository\StaffRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct(
        private StaffRepositoryInterface $staffRepository,
        private RoleRepositoryInterface  $roleRepository)
    {
        $this->middleware(['permission:manage roles']);
    }

    public function index(Request $request): View
    {
        $users = $this->staffRepository->filterAndPaginate($request, 12, ['created_at', 'desc'], [['id', '!=', 1]]);
        return $this->render('backend.staff.index', compact('users'));
    }

    public function archive(Request $request): View
    {
        $users = $this->staffRepository->filterAndPaginate($request, 12, onlyTrashed: true);
        $archive = true;
        return $this->render('backend.staff.index', compact('users', 'archive'));
    }


    public function restore(int $staffId)
    {
        $staff = $this->staffRepository->getModel()->withTrashed()->find($staffId);
        $staff->restore();

        return redirect()->route('backend.staff.index')->with('message', ['type' => 'Success', 'message' => 'Staff user has been restored successfully']);
    }

    public function create(Request $request): View
    {
        $roles = $this->roleRepository->all()->except(2);
        return $this->render('backend.staff.create', compact('roles'));
    }

    public function store(StaffDataRequest $request): RedirectResponse
    {
        if ($this->staffRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Staff user has been created successfully'];
        }
        return redirect()->route('backend.staff.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(Request $request, Staff $staff): View
    {
        $roles = $this->roleRepository->all()->except(2);
        return $this->render('backend.staff.create', compact('roles', 'staff'));
    }

    public function update(StaffDataRequest $request, Staff $staff): RedirectResponse
    {
        if ($this->staffRepository->update($staff->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Staff user has been updated successfully'];
        }
        return redirect()->route('backend.staff.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(Request $request, Staff $staff): RedirectResponse
    {
        if ($this->staffRepository->delete($staff->id)) {
            $message = ['type' => 'Success', 'message' => 'Staff user has been deleted successfully'];
        }
        return redirect()->route('backend.staff.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
}
