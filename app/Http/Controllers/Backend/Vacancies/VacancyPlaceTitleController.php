<?php

namespace App\Http\Controllers\Backend\Vacancies;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\VacancyPlaceTitleDataRequest;
use App\Models\VacancyPlaceTitle;
use App\Repository\VacancyPlaceTitleRepositoryInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class VacancyPlaceTitleController extends BackendController
{
    public function __construct(
        private VacancyPlaceTitleRepositoryInterface $vacancyPlaceTitleRepository
    )
    {

    }

    public function index(Request $request): View
    {
        abort_unless(Gate::allows('edit products'), 403);
        $titles = $this->vacancyPlaceTitleRepository->filterAndPaginate($request);

        return $this->render('backend.vacancy_place_titles.index', compact('titles'));
    }

    public function store(VacancyPlaceTitleDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('edit vacancies'), 403);

        try {
            $this->vacancyPlaceTitleRepository->create($request->validated());
            $message = ['type' => 'Success', 'message' => 'Vacancy place title has been created successfully'];

        } catch (Exception $exception) {
            Log::error('VacancyPlaceTitleController@store: ' . $exception->getMessage(), ['exception' => $exception]);
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.vacancy_place_titles.index')->with(compact('message'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('edit vacancies'), 403);

        return $this->render('backend.vacancy_place_titles.create');
    }

    public function edit(VacancyPlaceTitle $vacancyPlaceTitle): View
    {
        abort_unless(Gate::allows('edit vacancies'), 403);

        return $this->render('backend.vacancy_place_titles.create', compact('vacancyPlaceTitle'));
    }

    public function destroy(VacancyPlaceTitle $vacancyPlaceTitle): RedirectResponse
    {
        abort_unless(Gate::allows('edit products'), 403);

        try {
            $this->vacancyPlaceTitleRepository->delete($vacancyPlaceTitle->id);
            $message = ['type' => 'Success', 'message' => 'Vacancy Place Title has been deleted successfully'];
        } catch (Exception $exception) {
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }
        return redirect()->route('backend.vacancy_place_titles.index')->with(compact('message'));
    }

    public function update(VacancyPlaceTitleDataRequest $request, VacancyPlaceTitle $vacancyPlaceTitle): RedirectResponse
    {
        abort_unless(Gate::allows('edit products'), 403);
        try {
            $this->vacancyPlaceTitleRepository->update($vacancyPlaceTitle->id, $request->validated());
            $message = ['type' => 'Success', 'message' => 'Vacancy Place Title has been updated successfully'];

        } catch (Exception $exception) {
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.vacancy_place_titles.index')->with(compact('message'));
    }
}
