<?php

namespace App\Http\Controllers\Backend\Vacancies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\VacancyDataRequest;
use App\Models\Vacancy;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\VacancyPlaceTitleRepositoryInterface;
use App\Repository\VacancyRepositoryInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class VacancyController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface          $activityRepository,
        private VacancyRepositoryInterface           $vacancyRepository,
        private VacancyPlaceTitleRepositoryInterface $vacancyPlaceTitleRepository,
        private FileModelRepositoryInterface $fileRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create vacancies') || Gate::allows('edit vacancies') || Gate::allows('delete vacancies')), 403);
        $vacancies = $this->vacancyRepository->filterAndPaginate($request);

        return $this->render('backend.vacancies.index', compact('vacancies'));
    }

    public function store(VacancyDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create vacancies'), 403);
        try {
            $vacancy = $this->vacancyRepository->create($request->validated());
            $this->activityRepository->log('content', $vacancy, ['route_name' => 'backend.vacancies.edit', 'parameter' => 'vacancy', 'title' => $vacancy->title], Vacancy::$created);
            $message = ['type' => 'Success', 'message' => 'Vacancy has been created successfully'];

        } catch (Exception $exception) {
            Log::error('VacancyController@store: ' . $exception->getMessage(), ['exception' => $exception]);
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.vacancies.index')->with(compact('message'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create vacancies'), 403);
        $titles = $this->vacancyPlaceTitleRepository->all();
        $files = $this->fileRepository->all();

        return $this->render('backend.vacancies.create', compact('titles', 'files'));
    }

    public function edit(Vacancy $vacancy): View
    {
        abort_unless(Gate::allows('edit vacancies'), 403);
        $titles = $this->vacancyPlaceTitleRepository->all();
        $files = $this->fileRepository->all();

        return $this->render('backend.vacancies.create', compact('titles', 'vacancy', 'files'));
    }

    public function destroy(Vacancy $vacancy): RedirectResponse
    {
        abort_unless(Gate::allows('edit vacancies'), 403);

        try {
            $title = $vacancy->title;
            $this->vacancyRepository->delete($vacancy->id);
            $this->activityRepository->log('content', $vacancy, ['title' => $title], Vacancy::$deleted);
            $message = ['type' => 'Success', 'message' => 'Vacancy has been deleted successfully'];
        } catch (Exception $exception) {
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.vacancies.index')->with(compact('message'));
    }

    public function update(VacancyDataRequest $request, Vacancy $vacancy): RedirectResponse
    {
        abort_unless(Gate::allows('edit vacancies'), 403);
        try {
            $this->vacancyRepository->update($vacancy->id, $request->validated());
            $this->activityRepository->log('content', $vacancy, ['route_name' => 'backend.vacancies.edit', 'parameter' => 'vacancy', 'title' => $vacancy->title], Vacancy::$updated);
            $message = ['type' => 'Success', 'message' => 'Vacancy has been updated successfully'];

        } catch (Exception $exception) {
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.vacancies.index')->with(compact('message'));
    }
}
