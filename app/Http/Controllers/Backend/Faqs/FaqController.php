<?php

namespace App\Http\Controllers\Backend\Faqs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FaqDataRequest;
use App\Http\Requests\Backend\ManagerDataRequest;
use App\Http\Requests\Backend\StaticPageDataRequest;
use App\Models\FaqEntity;
use App\Models\Manager;
use App\Models\StaticPage;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\FaqRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use App\Repository\ManagementRepositoryInterface;
use App\Repository\StaticPageRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FaqController extends Controller
{

    public function __construct(
        public ActivityRepositoryInterface $activityRepository,
        private FaqRepositoryInterface $faqRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create faqs') || Gate::allows('edit faqs') || Gate::allows('delete faqs')), 403);
        $faqs = $this->faqRepository->filterAndPaginate($request);

        return $this->render('backend.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create faqs'), 403);

        return $this->render('backend.faqs.create');
    }

    public function store(FaqDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create faqs'), 403);

        if ($faq = $this->faqRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Faq has been created successfully'];
            $this->activityRepository->log('content', $faq, ['route_name' => 'backend.faq_entities.edit', 'parameter' => 'faq_entity', 'title' => $faq->title], FaqEntity::$created);
        }
        return redirect()->route('backend.faq_entities.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function edit(FaqEntity $faqEntity): View
    {
        abort_unless(Gate::allows('edit faqs'), 403);

        return $this->render('backend.faqs.create', compact('faqEntity'));
    }

    public function update(FaqDataRequest $request, FaqEntity $faqEntity): RedirectResponse
    {
        abort_unless(Gate::allows('edit faqs'), 403);
        if ($this->faqRepository->update($faqEntity->id, $request->validated())) {
            $message = ['type' => 'Success', 'message'=>'Faq has been updated successfully'];
            $this->activityRepository->log('content', $faqEntity, ['route_name' => 'backend.faq_entities.edit', 'parameter' => 'faq_entity', 'title' => $faqEntity->title], FaqEntity::$updated);
        }

        return redirect()->route('backend.faq_entities.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function destroy(FaqEntity $faqEntity): RedirectResponse
    {
        abort_unless(Gate::allows('delete faqs'), 403);
        $title = $faqEntity->title;
        if ($this->faqRepository->delete($faqEntity->id)) {
            $message = ['type' => 'Success', 'message'=>'Faq has been deleted successfully'];
            $this->activityRepository->log('content', $faqEntity, ['title' => $title], FaqEntity::$deleted);
        }
        return redirect()->route('backend.faq_entities.index')->with('message', $message ?? ['type' => 'Warning', 'message'=>'Something went wrong']);
    }

    public function toggleActive(Request $request, FaqEntity $faqEntity)
    {
        abort_unless(Gate::allows('edit faqs'), 403);
        if ($request->has('active')) {
            $active = (boolean) $request->post('active');
            $this->faqRepository->update($faqEntity->id, ['active' => $active]);
            $this->activityRepository->log('content', $faqEntity, ['route_name' => 'backend.faq_entities.edit', 'parameter' => 'faq_entity', 'title' => $faqEntity->title], $active ? FaqEntity::$activated : FaqEntity::$deactivated);
        }
    }

    public function reorderView(): View
    {
        abort_unless(Gate::allows('edit faqs'), 403);
        $faqs = $this->faqRepository->allNested()->toTree();

        return $this->render('backend.faqs.reorder', compact('faqs'));
    }

    public function reorder(Request $request) :bool
    {
        abort_unless(Gate::allows('edit managers'), 403);
        return $this->faqRepository->reorder($request);
    }
}
