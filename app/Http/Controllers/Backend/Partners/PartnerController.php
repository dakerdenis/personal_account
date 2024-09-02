<?php

namespace App\Http\Controllers\Backend\Partners;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BranchDataRequest;
use App\Http\Requests\Backend\ManagerDataRequest;
use App\Http\Requests\Backend\PartnerDataRequest;
use App\Http\Requests\Backend\StaticPageDataRequest;
use App\Models\Branch;
use App\Models\Manager;
use App\Models\Partner;
use App\Models\StaticPage;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\BranchRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use App\Repository\ManagementRepositoryInterface;
use App\Repository\PartnerRepositoryInterface;
use App\Repository\StaticPageRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PartnerController extends Controller
{

    public function __construct(
        public ActivityRepositoryInterface $activityRepository,
        private PartnerRepositoryInterface $partnerRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create partners') || Gate::allows('edit partners') || Gate::allows('delete partners')), 403);
        $partners = $this->partnerRepository->filterAndPaginate($request);

        return $this->render('backend.partners.index', compact('partners'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create partners'), 403);

        return $this->render('backend.partners.create');
    }

    public function store(PartnerDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create partners'), 403);

        if ($partner = $this->partnerRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Partner has been created successfully'];
            $this->activityRepository->log('content', $partner, ['route_name' => 'backend.partners.edit', 'parameter' => 'partner', 'title' => $partner->title], Partner::$created);
        }
        return redirect()->route('backend.partners.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function edit(Partner $partner): View
    {
        abort_unless(Gate::allows('edit partners'), 403);

        return $this->render('backend.partners.create', compact('partner'));
    }

    public function update(PartnerDataRequest $request, Partner $partner): RedirectResponse
    {
        abort_unless(Gate::allows('edit partners'), 403);
        if ($this->partnerRepository->update($partner->id, $request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Partners has been updated successfully'];
            $this->activityRepository->log('content', $partner, ['route_name' => 'backend.partners.edit', 'parameter' => 'partner', 'title' => $partner->title], Partner::$updated);
        }

        return redirect()->route('backend.partners.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        abort_unless(Gate::allows('delete partners'), 403);
        $title = $partner->title;
        if ($this->partnerRepository->delete($partner->id)) {
            $message = ['type' => 'Success', 'message'=>'Partner has been deleted successfully'];
            $this->activityRepository->log('content', $partner, ['title' => $title], Partner::$deleted);
        }
        return redirect()->route('backend.partners.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function toggleActive(Request $request, Partner $partner)
    {
        abort_unless(Gate::allows('edit partners'), 403);
        if ($request->has('active')) {
            $active = (boolean) $request->post('active');
            $this->partnerRepository->update($partner->id, ['active' => $active]);
            $this->activityRepository->log('content', $partner, ['route_name' => 'backend.partners.edit', 'parameter' => 'partner', 'title' => $partner->title], $active ? Partner::$activated : Partner::$deactivated);
        }
    }

    public function reorderView(): View
    {
        abort_unless(Gate::allows('edit partners'), 403);
        $partners = $this->partnerRepository->allNested()->toTree();

        return $this->render('backend.partners.reorder', compact('partners'));
    }

    public function reorder(Request $request) :bool
    {
        abort_unless(Gate::allows('edit partners'), 403);

        return $this->partnerRepository->reorder($request);
    }
}
