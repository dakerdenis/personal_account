<?php

namespace App\Http\Controllers\Backend\Sliders;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\SlidesDataRequest;
use App\Models\Slider;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\SlideRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class SlideController extends BackendController
{

    private SlideRepositoryInterface $slideRepository;

    private ActivityRepositoryInterface $activityRepository;

    public function __construct(SlideRepositoryInterface $slideRepository, ActivityRepositoryInterface $activityRepository)
    {
        $this->slideRepository = $slideRepository;
        $this->activityRepository = $activityRepository;
        $this->middleware(['permission:manage sliders']);
    }

    public function create(Request $request, Slider $slider): View
    {
        $slides = $slider->slides()->ordered()->get();
        return $this->render('backend.sliders.slides.create', compact('slider', 'slides'));
    }

    public function store(SlidesDataRequest $request, Slider $slider): RedirectResponse
    {
        if ($result = $this->slideRepository->create($request->validated() + ['slider_id' => $slider->id])) {
            $message = ['type' => 'Success', 'message' => 'Slides has been added successfully'];
            $this->activityRepository->log('content', $slider, ['route_name' => 'backend.sliders.edit', 'parameter' => 'slider', 'title' => $slider->name], Slider::$updated);
        }
        return redirect()->route('backend.sliders.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function getEmptySlide(Request $request): string
    {
        $id = Str::random() . rand(1, 999);
        return $this->render('backend.partials.slide', compact('id'))->render();
    }

    public function getLinkBlock(mixed $slideId)
    {
        $id = Str::random(24) . time();

        return view('backend.partials.slide-links', compact('id', 'slideId'));
    }
}
