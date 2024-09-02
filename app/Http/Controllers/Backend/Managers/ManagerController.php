<?php

namespace App\Http\Controllers\Backend\Managers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ManagerDataRequest;
use App\Http\Requests\Backend\StaticPageDataRequest;
use App\Models\Manager;
use App\Models\StaticPage;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use App\Repository\ManagementRepositoryInterface;
use App\Repository\StaticPageRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ManagerController extends Controller
{

    public function __construct(
        public ActivityRepositoryInterface $activityRepository,
        private ManagementRepositoryInterface $managementRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create managers') || Gate::allows('edit managers') || Gate::allows('delete managers')), 403);
        $managers = $this->managementRepository->filterAndPaginate($request);

        return $this->render('backend.managers.index', compact('managers'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create managers'), 403);

        return $this->render('backend.managers.create');
    }

    public function store(ManagerDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create managers'), 403);

        if ($manager = $this->managementRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Manager has been created successfully'];
            $this->activityRepository->log('content', $manager, ['route_name' => 'backend.managers.edit', 'parameter' => 'manager', 'title' => $manager->title], Manager::$created);
        }
        return redirect()->route('backend.managers.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function edit(Manager $manager): View
    {
        abort_unless(Gate::allows('edit managers'), 403);

        return $this->render('backend.managers.create', compact('manager'));
    }

    public function update(ManagerDataRequest $request, Manager $manager): RedirectResponse
    {
        abort_unless(Gate::allows('edit managers'), 403);
        if ($this->managementRepository->update($manager->id, $request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Manager has been updated successfully'];
            $this->activityRepository->log('content', $manager, ['route_name' => 'backend.managers.edit', 'parameter' => 'manager', 'title' => $manager->title], Manager::$updated);
        }

        return redirect()->route('backend.managers.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function destroy(Manager $manager): RedirectResponse
    {
        abort_unless(Gate::allows('delete managers'), 403);
        $title = $manager->title;
        if ($this->managementRepository->delete($manager->id)) {
            $message = ['type' => 'Success', 'message'=>'Manager has been deleted successfully'];
            $this->activityRepository->log('content', $manager, ['title' => $title], Manager::$deleted);
        }
        return redirect()->route('backend.managers.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function toggleActive(Request $request, Manager $manager)
    {
        abort_unless(Gate::allows('edit managers'), 403);
        if ($request->has('active')) {
            $active = (boolean) $request->post('active');
            $this->managementRepository->update($manager->id, ['active' => $active]);
            $this->activityRepository->log('content', $manager, ['route_name' => 'backend.managers.edit', 'parameter' => 'manager', 'title' => $manager->title], $active ? Manager::$activated : Manager::$deactivated);
        }
    }

    public function reorderView(): View
    {
        abort_unless(Gate::allows('edit managers'), 403);
        $managers = $this->managementRepository->allNested()->toTree();

        return $this->render('backend.managers.reorder', compact('managers'));
    }

    public function reorder(Request $request) :bool
    {
        abort_unless(Gate::allows('edit managers'), 403);
        return $this->managementRepository->reorder($request);
    }
}
