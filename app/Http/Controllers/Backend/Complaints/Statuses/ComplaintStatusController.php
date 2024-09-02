<?php

namespace App\Http\Controllers\Backend\Complaints\Statuses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ComplaintStatusDataRequest;
use App\Models\ComplaintStatus;
use App\Repository\ComplaintStatusRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ComplaintStatusController extends Controller
{
    public function __construct(
        private ComplaintStatusRepositoryInterface $complaintStatusRepository
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless(Gate::allows('edit complaints'), 403);
        $complaintStatuses = $this->complaintStatusRepository->filterAndPaginate($request, 12);

        return $this->render('backend.complaint_statuses.index', compact('complaintStatuses'));
    }

    public function store(ComplaintStatusDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('edit complaints'), 403);

        if ($this->complaintStatusRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Complaint status has been created successfully'];
        }

        return redirect()->route('backend.complaint_statuses.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function create(): View
    {
        abort_unless(Gate::allows('edit complaints'), 403);

        return $this->render('backend.complaint_statuses.create');
    }

    public function edit(ComplaintStatus $complaintStatus): View
    {
        abort_unless(Gate::allows('edit complaints'), 403);

        return $this->render('backend.complaint_statuses.create', compact('complaintStatus'));
    }

    public function update(ComplaintStatusDataRequest $request, ComplaintStatus $complaintStatus): RedirectResponse
    {
        abort_unless(Gate::allows('edit complaints'), 403);
        if ($this->complaintStatusRepository->update($complaintStatus->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Complaint status has been updated successfully'];
        }

        return redirect()->route('backend.complaint_statuses.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(ComplaintStatus $complaintStatus): RedirectResponse
    {
        abort_unless(Gate::allows('delete complaints'), 403);
        if ($this->complaintStatusRepository->delete($complaintStatus->id)) {
            $message = ['type' => 'Success', 'message' => 'Complaint status has been deleted successfully'];
        }

        return redirect()->route('backend.complaint_statuses.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
}
