<?php

namespace App\Http\Controllers\Backend\Complaints;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ComplaintDataRequest;
use App\Http\Requests\Backend\VacancyDataRequest;
use App\Models\Complaint;
use App\Models\Vacancy;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\ComplaintRepositoryInterface;
use App\Repository\ComplaintStatusRepositoryInterface;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\VacancyPlaceTitleRepositoryInterface;
use App\Repository\VacancyRepositoryInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ComplaintController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface          $activityRepository,
        private ComplaintStatusRepositoryInterface           $complaintStatusRepository,
        private ComplaintRepositoryInterface          $complaintRepository,
    )
    {
        abort(403);
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('edit complaints') || Gate::allows('edit complaints') || Gate::allows('edit complaints')), 403);
        $complaints = $this->complaintRepository->filterAndPaginate($request);
        $complaintStatuses = $this->complaintStatusRepository->all();

        return $this->render('backend.complaints.index', compact('complaints', 'complaintStatuses'));
    }

    public function store(): void
    {
        abort(404);
    }

    public function create(): void
    {
        abort(404);
    }

    public function edit(Complaint $complaint): View
    {
        abort_unless(Gate::allows('edit complaints'), 403);
        $statuses = $this->complaintStatusRepository->all();

        return $this->render('backend.complaints.create', compact('statuses', 'complaint'));
    }

    public function destroy(Vacancy $vacancy): void
    {
        abort(404);
    }

    public function update(ComplaintDataRequest $request, Complaint $complaint): RedirectResponse
    {
        abort_unless(Gate::allows('edit complaints'), 403);
        try {
            $complaint->complaint_status_id = $request->complaint_status_id;
            $complaint->change_status_date = $request->change_status_date;
            $complaint->save();
            $this->activityRepository->log('content', $complaint, ['route_name' => 'backend.complaints.edit', 'parameter' => 'complaint', 'title' => $complaint->title], Complaint::$updated);
            $message = ['type' => 'Success', 'message' => 'Complaint has been updated successfully'];

        } catch (Exception $exception) {
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.complaints.index')->with(compact('message'));
    }
}
