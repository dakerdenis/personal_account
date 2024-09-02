<?php

namespace App\Http\Controllers\Backend\Galleries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\GalleryDataRequest;
use App\Models\Gallery;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GalleryController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private GalleryRepositoryInterface  $galleryRepository)
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create galleries') || Gate::allows('edit galleries') || Gate::allows('delete galleries')), 403);
        $galleries = $this->galleryRepository->filterAndPaginate($request, 12);

        return $this->render('backend.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create galleries'), 403);

        return $this->render('backend.galleries.create');
    }

    public function store(GalleryDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create galleries'), 403);

        if ($gallery = $this->galleryRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Gallery has been created successfully'];
            $this->activityRepository->log('content', $gallery, ['route_name' => 'backend.galleries.edit', 'parameter' => 'gallery', 'title' => $gallery->title], Gallery::$created);
        }
        return redirect()->route('backend.galleries.edit', ['gallery' => $gallery->id])->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(Gallery $gallery): View
    {
        abort_unless(Gate::allows('edit galleries'), 403);

        return $this->render('backend.galleries.create', compact('gallery'));
    }

    public function update(GalleryDataRequest $request, Gallery $gallery): RedirectResponse
    {
        abort_unless(Gate::allows('edit galleries'), 403);
        if ($this->galleryRepository->update($gallery->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Gallery has been updated successfully'];
            $this->activityRepository->log('content', $gallery, ['route_name' => 'backend.galleries.edit', 'parameter' => 'gallery', 'title' => $gallery->title], Gallery::$updated);
        }
        return redirect()->route('backend.galleries.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function addImages(Request $request, Gallery $gallery): string
    {
        $html = '';
        if ($request->has('photo')) {
            if ($request->hasFile('photo')) {
                $gallery->addMultipleMediaFromRequest(['photo'])->each(function ($fileAdder) use (&$html) {
                    $image = $fileAdder->toMediaCollection();
                    $html .= \view('backend.partials.gallery_image', compact('image'))->render();
                });
            }
        }
        return $html;
    }

    public function destroy(Request $request, Gallery $gallery): RedirectResponse
    {
        abort_unless(Gate::allows('delete galleries'), 403);
        $title = $gallery->title;
        if ($this->galleryRepository->delete($gallery->id)) {
            $message = ['type' => 'Success', 'message' => 'Gallery has been deleted successfully'];
            $this->activityRepository->log('content', $gallery, ['title' => $title], Gallery::$deleted);
        }
        return redirect()->route('backend.galleries.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
}
