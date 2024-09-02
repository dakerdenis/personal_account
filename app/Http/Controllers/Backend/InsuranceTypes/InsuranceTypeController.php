<?php

namespace App\Http\Controllers\Backend\InsuranceTypes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\InsuranceTypeDataRequest;
use App\Models\InsuranceType;
use App\Repository\InsuranceTypeRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InsuranceTypeController extends Controller
{

    public function __construct(
        private InsuranceTypeRepositoryInterface $insuranceTypeRepository,
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create insurance_types') || Gate::allows('edit insurance_types') || Gate::allows('delete insurance_types')), 403);
        $insuranceTypes = $this->insuranceTypeRepository->filterAndPaginate($request);

        return $this->render('backend.insurance_types.index', compact('insuranceTypes'));
    }

    public function store(InsuranceTypeDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create insurance_types'), 403);

        if ($this->insuranceTypeRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Insurance Type has been created successfully'];
        }

        return redirect()->route('backend.insurance_types.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create insurance_types'), 403);

        return $this->render('backend.insurance_types.create');
    }

    public function edit(InsuranceType $insuranceType): View
    {
        abort_unless(Gate::allows('edit insurance_types'), 403);

        return $this->render('backend.insurance_types.create', compact('insuranceType'));
    }

    public function destroy(InsuranceType $insuranceType): RedirectResponse
    {
        abort_unless(Gate::allows('delete insurance_types'), 403);
        if ($this->insuranceTypeRepository->delete($insuranceType->id)) {
            $message = ['type' => 'Success', 'message' => 'Insurance Type has been deleted successfully'];
        }

        return redirect()->route('backend.insurance_types.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function toggleActive(Request $request, InsuranceType $insuranceType)
    {
        abort_unless(Gate::allows('edit insurance_types'), 403);
        if ($request->has('active')) {
            $active = (boolean)$request->post('active');
            $this->insuranceTypeRepository->update($insuranceType->id, ['active' => $active]);
        }
    }

    public function update(InsuranceTypeDataRequest $request, InsuranceType $insuranceType): RedirectResponse
    {
        abort_unless(Gate::allows('edit insurance_types'), 403);
        if ($this->insuranceTypeRepository->update($insuranceType->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Insurance Type has been updated successfully'];
        }

        return redirect()->route('backend.insurance_types.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function reorderView(): View
    {
        abort_unless(Gate::allows('edit insurance_types'), 403);
        $insuranceTypes = $this->insuranceTypeRepository->allNested()->toTree();

        return $this->render('backend.insurance_types.reorder', compact('insuranceTypes'));
    }

    public function reorder(Request $request): bool
    {
        abort_unless(Gate::allows('edit insurance_types'), 403);

        return $this->insuranceTypeRepository->reorder($request);
    }
}
