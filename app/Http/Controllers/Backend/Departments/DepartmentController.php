<?php

namespace App\Http\Controllers\Backend\Departments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\DepartmentDataRequest;
use App\Http\Requests\Backend\ManagerDataRequest;
use App\Models\Department;
use App\Models\Manager;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\DepartmentRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller
{

    public function __construct(
        public ActivityRepositoryInterface $activityRepository,
        private DepartmentRepositoryInterface $departmentRepository,
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create departments') || Gate::allows('edit departments') || Gate::allows('delete departments')), 403);
        $departments = $this->departmentRepository->filterAndPaginate($request);

        return $this->render('backend.departments.index', compact('departments'));
    }

    public function store(DepartmentDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create departments'), 403);

        if ($department = $this->departmentRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Department has been created successfully'];
            $this->activityRepository->log(
                'content',
                $department,
                ['route_name' => 'backend.departments.edit', 'parameter' => 'department', 'title' => $department->title],
                Department::$created
            );
        }

        return redirect()->route('backend.departments.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create departments'), 403);

        return $this->render('backend.departments.create');
    }

    public function edit(Department $department): View
    {
        abort_unless(Gate::allows('edit departments'), 403);

        return $this->render('backend.departments.create', compact('department'));
    }

    public function destroy(Department $department): RedirectResponse
    {
        abort_unless(Gate::allows('delete departments'), 403);
        $title = $department->title;
        if ($this->departmentRepository->delete($department->id)) {
            $message = ['type' => 'Success', 'message' => 'Department has been deleted successfully'];
            $this->activityRepository->log('content', $department, ['title' => $title], Department::$deleted);
        }

        return redirect()->route('backend.departments.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function toggleActive(Request $request, Department $department)
    {
        abort_unless(Gate::allows('edit departments'), 403);
        if ($request->has('active')) {
            $active = (boolean)$request->post('active');
            $this->departmentRepository->update($department->id, ['active' => $active]);
            $this->activityRepository->log(
                'content',
                $department,
                ['route_name' => 'backend.departments.edit', 'parameter' => 'department', 'title' => $department->title],
                $active ? Manager::$activated : Manager::$deactivated
            );
        }
    }

    public function update(DepartmentDataRequest $request, Department $department): RedirectResponse
    {
        abort_unless(Gate::allows('edit departments'), 403);
        if ($this->departmentRepository->update($department->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Department has been updated successfully'];
            $this->activityRepository->log('content', $department, ['route_name' => 'backend.departments.edit', 'parameter' => 'department', 'title' => $department->title], Department::$updated);
        }

        return redirect()->route('backend.departments.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function reorderView(): View
    {
        abort_unless(Gate::allows('edit departments'), 403);
        $departments = $this->departmentRepository->allNested()->toTree();

        return $this->render('backend.departments.reorder', compact('departments'));
    }

    public function reorder(Request $request): bool
    {
        abort_unless(Gate::allows('edit departments'), 403);

        return $this->departmentRepository->reorder($request);
    }
}
