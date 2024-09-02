<?php

namespace App\Http\Controllers\Backend\Reports\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ReportGroupDataRequest;
use App\Http\Requests\Backend\ReportYearDataRequest;
use App\Models\ReportGroup;
use App\Models\ReportYear;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\Eloquent\ReportGroupRepository;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\FileRepositoryInterface;
use App\Repository\ReportGroupRepositoryInterface;
use App\Repository\ReportYearRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportGroupController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private ReportGroupRepositoryInterface $reportGroupRepository,
        private ReportYearRepositoryInterface $reportYearRepository,
        private FileModelRepositoryInterface $fileRepository,
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create reports data') || Gate::allows('edit reports data') || Gate::allows('delete reports data')), 403);
        $groups = $this->reportGroupRepository->filterAndPaginate($request, 12);

        return $this->render('backend.reports.groups.index', compact('groups'));
    }

    public function store(ReportGroupDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create reports data'), 403);

        if ($reportGroup = $this->reportGroupRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Report Group has been created successfully'];
            $this->activityRepository->log(
                'content',
                $reportGroup,
                ['route_name' => 'backend.report_groups.edit', 'parameter' => 'report_group', 'title' => $reportGroup->title],
                ReportGroup::$created
            );
        }

        return redirect()->route('backend.report_groups.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create reports data'), 403);
        $years = $this->reportYearRepository->all();
        $files = $this->fileRepository->all();

        return $this->render('backend.reports.groups.create', compact('years', 'files'));
    }

    public function edit(ReportGroup $reportGroup): View
    {
        abort_unless(Gate::allows('edit reports data'), 403);
        $years = $this->reportYearRepository->all();
        $files = $this->fileRepository->all();

        return $this->render('backend.reports.groups.create', compact('reportGroup', 'years', 'files'));
    }

    public function update(ReportGroupDataRequest $request, ReportGroup $reportGroup): RedirectResponse
    {
        abort_unless(Gate::allows('edit reports data'), 403);
        if ($this->reportGroupRepository->update($reportGroup->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Report Group has been updated successfully'];
            $this->activityRepository->log(
                'content',
                $reportGroup,
                ['route_name' => 'backend.report_groups.edit', 'parameter' => 'report_group', 'title' => $reportGroup->title],
                ReportGroup::$updated
            );
        }

        return redirect()->route('backend.report_groups.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(ReportGroup $reportGroup): RedirectResponse
    {
        abort_unless(Gate::allows('delete reports data'), 403);
        $title = $reportGroup->title;
        if ($this->reportGroupRepository->delete($reportGroup->id)) {
            $message = ['type' => 'Success', 'message' => 'Report Group has been deleted successfully'];
            $this->activityRepository->log('content', $reportGroup, ['title' => $title], ReportGroup::$deleted);
        }

        return redirect()->route('backend.report_groups.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function reorderView(Request $request): View
    {
        abort_unless(Gate::allows('edit reports data'), 403);

        $years = $this->reportYearRepository->getModel()->orderBy('year')->get();

        return $this->render('backend.reports.groups.reorder', compact('years'));
    }

    public function reorder(Request $request) :bool
    {
        abort_unless(Gate::allows('edit reports data'), 403);

        return $this->reportGroupRepository->reorder($request);
    }
}
