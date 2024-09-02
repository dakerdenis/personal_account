<?php

namespace App\Http\Controllers\Backend\Files;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FileDataRequest;
use App\Http\Requests\Backend\GalleryDataRequest;
use App\Models\File;
use App\Models\Gallery;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\FileRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FileModelController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private FileModelRepositoryInterface  $fileRepository)
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create files') || Gate::allows('edit files') || Gate::allows('delete files')), 403);
        $files = $this->fileRepository->filterAndPaginate($request, 12);

        return $this->render('backend.files.index', compact('files'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create files'), 403);

        return $this->render('backend.files.create');
    }

    public function store(FileDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create files'), 403);

        if ($file = $this->fileRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'File has been created successfully'];
            $this->activityRepository->log('content', $file, ['route_name' => 'backend.file.edit', 'parameter' => 'file', 'title' => $file->title], File::$created);
        }

        return redirect()->route('backend.file.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(File $file): View
    {
        abort_unless(Gate::allows('edit files'), 403);

        return $this->render('backend.files.create', compact('file'));
    }

    public function update(FileDataRequest $request, File $file): RedirectResponse
    {
        abort_unless(Gate::allows('edit files'), 403);
        if ($this->fileRepository->update($file->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'File has been updated successfully'];
            $this->activityRepository->log('content', $file, ['route_name' => 'backend.file.edit', 'parameter' => 'file', 'title' => $file->title], File::$updated);
        }

        return redirect()->route('backend.file.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(File $file): RedirectResponse
    {
        abort_unless(Gate::allows('delete files'), 403);
        $title = $file->title;
        if ($this->fileRepository->delete($file->id)) {
            $message = ['type' => 'Success', 'message' => 'File has been deleted successfully'];
            $this->activityRepository->log('content', $file, ['title' => $title], File::$deleted);
        }

        return redirect()->route('backend.file.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }


    public function toggleActive(Request $request, File $file)
    {
        abort_unless(Gate::allows('edit static files'), 403);
        if ($request->has('active')) {
            $active = (boolean) $request->post('active');
            $this->fileRepository->update($file->id, ['active' => $active]);
            $this->activityRepository->log('content', $file, ['route_name' => 'backend.file.edit', 'parameter' => 'file', 'title' => $file->title], $active ? File::$activated : File::$deactivated);
        }
    }
}
