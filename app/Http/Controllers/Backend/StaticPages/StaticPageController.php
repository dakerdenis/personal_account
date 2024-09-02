<?php

namespace App\Http\Controllers\Backend\StaticPages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StaticPageDataRequest;
use App\Models\StaticPage;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use App\Repository\StaticPageRepositoryInterface;
use App\Repository\UsefulLinkRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StaticPageController extends Controller
{

    public function __construct(
        public ActivityRepositoryInterface $activityRepository,
        public StaticPageRepositoryInterface $staticPageRepository,
        public GalleryRepositoryInterface $galleryRepository,
        private UsefulLinkRepositoryInterface $usefulLinkRepository,
        private FileModelRepositoryInterface $fileModelRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create static pages') || Gate::allows('edit static pages') || Gate::allows('delete static pages')), 403);
        $static_pages = $this->staticPageRepository->filterAndPaginate($request);
        return $this->render('backend.static_pages.index', compact('static_pages'));
    }

    public function create(Request $request): View
    {
        abort_unless(Gate::allows('create static pages'), 403);
        $galleries = $this->galleryRepository->all();
        $usefulLinks = $this->usefulLinkRepository->all();
        $files = $this->fileModelRepository->all();

        return $this->render('backend.static_pages.create', compact('galleries', 'usefulLinks', 'files'));
    }

    public function store(StaticPageDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create static pages'), 403);
        if ($static_page = $this->staticPageRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Page has been created successfully'];
            $this->activityRepository->log('content', $static_page, ['route_name' => 'backend.static_pages.edit', 'parameter' => 'static_page', 'title' => $static_page->title], StaticPage::$created);
        }

        return redirect()->route('backend.static_pages.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function edit(Request $request, StaticPage $static_page): View
    {
        abort_unless(Gate::allows('edit static pages'), 403);
        $galleries = $this->galleryRepository->all();
        $usefulLinks = $this->usefulLinkRepository->all();
        $files = $this->fileModelRepository->all();

        return $this->render('backend.static_pages.create', compact('static_page', 'galleries', 'usefulLinks', 'files'));
    }

    public function update(StaticPageDataRequest $request, StaticPage $static_page): RedirectResponse
    {
        abort_unless(Gate::allows('edit static pages'), 403);
        if ($this->staticPageRepository->update($static_page->id, $request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Page has been updated successfully'];
            $this->activityRepository->log('content', $static_page, ['route_name' => 'backend.static_pages.edit', 'parameter' => 'static_page', 'title' => $static_page->title], StaticPage::$updated);
        }
        return redirect()->route('backend.static_pages.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function destroy(Request $request, StaticPage $static_page): RedirectResponse
    {
        abort_unless(Gate::allows('delete static pages'), 403);
        $title = $static_page->title;
        if ($this->staticPageRepository->delete($static_page->id)) {
            $message = ['type' => 'Success', 'message'=>'Page has been deleted successfully'];
            $this->activityRepository->log('content', $static_page, ['title' => $title], StaticPage::$deleted);
        }
        return redirect()->route('backend.static_pages.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function toggleActive(Request $request, StaticPage $static_page)
    {
        abort_unless(Gate::allows('edit static pages'), 403);
        if ($request->has('active')) {
            $active = (boolean) $request->post('active');
            $this->staticPageRepository->update($static_page->id, ['active' => $active]);
            $this->activityRepository->log('content', $static_page, ['route_name' => 'backend.static_pages.edit', 'parameter' => 'static_page', 'title' => $static_page->title], $active ? StaticPage::$activated : StaticPage::$deactivated);
        }
    }

    public function reorderView(Request $request): View
    {
        abort_unless(Gate::allows('edit static pages'), 403);
        $static_pages = $this->staticPageRepository->allNested()->toTree();
        return $this->render('backend.static_pages.reorder', compact('static_pages'));
    }

    public function reorder(Request $request) :bool
    {
        abort_unless(Gate::allows('edit static pages'), 403);
        return $this->staticPageRepository->reorder($request);
    }
}
