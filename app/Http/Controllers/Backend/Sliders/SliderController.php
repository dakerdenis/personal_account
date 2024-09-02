<?php

namespace App\Http\Controllers\Backend\Sliders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SliderDataRequest;
use App\Models\Slider;
use App\Repository\SliderRepositoryInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class SliderController extends Controller
{

    public function __construct(private SliderRepositoryInterface $sliderRepository)
    {
        $this->middleware(['permission:manage sliders']);
    }

    public function index(): View
    {
        $sliders = $this->sliderRepository->all();
        return $this->render('backend.sliders.index', compact('sliders'));
    }

    public function create(): View
    {
        return $this->render('backend.sliders.create');
    }

    public function store(SliderDataRequest $request): RedirectResponse
    {
        $machine_name = Str::snake($request->validated()['name']);
        if ($slider = $this->sliderRepository->create($request->validated() + ['machine_name' => $machine_name])) {
            $message = ['type' => 'Success', 'message' => 'Slider has been created successfully'];
        }
        return redirect()->route('backend.sliders.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(Slider $slider): View
    {
        return $this->render('backend.sliders.create', compact('slider'));
    }

    public function update(SliderDataRequest $request, Slider $slider): RedirectResponse
    {
        $data = $request->validated();
        if ($this->sliderRepository->update($slider->id, $data)) {
            $message = ['type' => 'Success', 'message' => 'Slider has been updated successfully'];
        }
        return redirect()->route('backend.sliders.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        if ($this->sliderRepository->delete($slider->id)) {
            $message = ['type' => 'Success', 'message' => 'Slider has been deleted successfully'];
        }
        return redirect()->route('backend.sliders.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
}
