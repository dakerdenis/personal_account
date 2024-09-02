<?php

namespace App\Http\Controllers\Backend\Branches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BranchDataRequest;
use App\Http\Requests\Backend\ManagerDataRequest;
use App\Http\Requests\Backend\StaticPageDataRequest;
use App\Models\Branch;
use App\Models\Manager;
use App\Models\StaticPage;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\BranchRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use App\Repository\ManagementRepositoryInterface;
use App\Repository\StaticPageRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BranchController extends Controller
{

    public function __construct(
        public ActivityRepositoryInterface $activityRepository,
        private BranchRepositoryInterface $branchRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create branches') || Gate::allows('edit branches') || Gate::allows('delete branches')), 403);
        $branches = $this->branchRepository->filterAndPaginate($request);

        return $this->render('backend.branches.index', compact('branches'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create branches'), 403);

        return $this->render('backend.branches.create');
    }

    public function store(BranchDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create branches'), 403);

        if ($branch = $this->branchRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Branch has been created successfully'];
            $this->activityRepository->log('content', $branch, ['route_name' => 'backend.branches.edit', 'parameter' => 'branch', 'title' => $branch->title], Branch::$created);
        }
        return redirect()->route('backend.branches.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function edit(Branch $branch): View
    {
        abort_unless(Gate::allows('edit branches'), 403);

        return $this->render('backend.branches.create', compact('branch'));
    }

    public function update(BranchDataRequest $request, Branch $branch): RedirectResponse
    {
        abort_unless(Gate::allows('edit branches'), 403);
        if ($this->branchRepository->update($branch->id, $request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Branches has been updated successfully'];
            $this->activityRepository->log('content', $branch, ['route_name' => 'backend.branches.edit', 'parameter' => 'branch', 'title' => $branch->title], Branch::$updated);
        }

        return redirect()->route('backend.branches.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        abort_unless(Gate::allows('delete branches'), 403);
        $title = $branch->title;
        if ($this->branchRepository->delete($branch->id)) {
            $message = ['type' => 'Success', 'message'=>'Branch has been deleted successfully'];
            $this->activityRepository->log('content', $branch, ['title' => $title], Branch::$deleted);
        }
        return redirect()->route('backend.branches.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function toggleActive(Request $request, Branch $branch)
    {
        abort_unless(Gate::allows('edit branches'), 403);
        if ($request->has('active')) {
            $active = (boolean) $request->post('active');
            $this->branchRepository->update($branch->id, ['active' => $active]);
            $this->activityRepository->log('content', $branch, ['route_name' => 'backend.branches.edit', 'parameter' => 'branch', 'title' => $branch->title], $active ? Branch::$activated : Branch::$deactivated);
        }
    }

    public function reorderView(): View
    {
        abort_unless(Gate::allows('edit managers'), 403);
        $branches = $this->branchRepository->allNested()->toTree();

        return $this->render('backend.branches.reorder', compact('branches'));
    }

    public function reorder(Request $request) :bool
    {
        abort_unless(Gate::allows('edit branches'), 403);

        return $this->branchRepository->reorder($request);
    }
}
