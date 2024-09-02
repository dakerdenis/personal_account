<?php

namespace App\Http\Controllers\Backend\Reports\Years;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ReportYearDataRequest;
use App\Models\ReportYear;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\ReportYearRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportYearController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private ReportYearRepositoryInterface $reportYearRepository
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create reports data') || Gate::allows('edit reports data') || Gate::allows('delete reports data')), 403);
        $years = $this->reportYearRepository->filterAndPaginate($request, 12);

        return $this->render('backend.reports.years.index', compact('years'));
    }

    public function store(ReportYearDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create reports data'), 403);

        if ($reportYear = $this->reportYearRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Report Year has been created successfully'];
            $this->activityRepository->log(
                'content',
                $reportYear,
                ['route_name' => 'backend.report_years.edit', 'parameter' => 'report_year', 'title' => $reportYear->title],
                ReportYear::$created
            );
        }

        return redirect()->route('backend.report_years.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create reports data'), 403);

        return $this->render('backend.reports.years.create');
    }

    public function edit(ReportYear $reportYear): View
    {
        abort_unless(Gate::allows('edit reports data'), 403);

        return $this->render('backend.reports.years.create', compact('reportYear'));
    }

    public function update(ReportYearDataRequest $request, ReportYear $reportYear): RedirectResponse
    {
        abort_unless(Gate::allows('edit reports data'), 403);
        if ($this->reportYearRepository->update($reportYear->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Report Year has been updated successfully'];
            $this->activityRepository->log(
                'content',
                $reportYear,
                ['route_name' => 'backend.report_years.edit', 'parameter' => 'report_year', 'title' => $reportYear->title],
                ReportYear::$updated
            );
        }

        return redirect()->route('backend.report_years.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(ReportYear $reportYear): RedirectResponse
    {
        abort_unless(Gate::allows('delete reports data'), 403);
        $title = $reportYear->title;
        if ($this->reportYearRepository->delete($reportYear->id)) {
            $message = ['type' => 'Success', 'message' => 'Report Year has been deleted successfully'];
            $this->activityRepository->log('content', $reportYear, ['title' => $title], ReportYear::$deleted);
        }

        return redirect()->route('backend.report_years.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
}
