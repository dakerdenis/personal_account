<?php

namespace App\Http\Controllers\Backend\UsefulLinks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FileDataRequest;
use App\Http\Requests\Backend\GalleryDataRequest;
use App\Http\Requests\Backend\UsefulLinkDataRequest;
use App\Models\File;
use App\Models\Gallery;
use App\Models\UsefulLink;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\FileRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use App\Repository\UsefulLinkRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsefulLinkController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private UsefulLinkRepositoryInterface  $usefulLinkRepository)
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create useful_links') || Gate::allows('edit useful_links') || Gate::allows('delete useful_links')), 403);
        $usefulLinks = $this->usefulLinkRepository->filterAndPaginate($request, 12);

        return $this->render('backend.useful_links.index', compact('usefulLinks'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create useful_links'), 403);

        return $this->render('backend.useful_links.create');
    }

    public function store(UsefulLinkDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create useful_links'), 403);

        if ($usefulLink = $this->usefulLinkRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Useful Link has been created successfully'];
            $this->activityRepository->log('content', $usefulLink, ['route_name' => 'backend.useful_links.edit', 'parameter' => 'useful_link', 'title' => $usefulLink->title], UsefulLink::$created);
        }

        return redirect()->route('backend.useful_links.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(UsefulLink $usefulLink): View
    {
        abort_unless(Gate::allows('edit useful_links'), 403);

        return $this->render('backend.useful_links.create', compact('usefulLink'));
    }

    public function update(UsefulLinkDataRequest $request, UsefulLink $usefulLink): RedirectResponse
    {
        abort_unless(Gate::allows('edit useful_links'), 403);
        if ($this->usefulLinkRepository->update($usefulLink->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Useful link has been updated successfully'];
            $this->activityRepository->log('content', $usefulLink, ['route_name' => 'backend.useful_links.edit', 'parameter' => 'file', 'title' => $usefulLink->title], UsefulLink::$updated);
        }

        return redirect()->route('backend.useful_links.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(UsefulLink $usefulLink): RedirectResponse
    {
        abort_unless(Gate::allows('delete useful_links'), 403);
        $title = $usefulLink->title;
        if ($this->usefulLinkRepository->delete($usefulLink->id)) {
            $message = ['type' => 'Success', 'message' => 'Useful link has been deleted successfully'];
            $this->activityRepository->log('content', $usefulLink, ['title' => $title], UsefulLink::$deleted);
        }

        return redirect()->route('backend.useful_links.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
}
