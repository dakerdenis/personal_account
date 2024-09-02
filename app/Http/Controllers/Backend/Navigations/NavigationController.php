<?php

namespace App\Http\Controllers\Backend\Navigations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\NavigationDataRequest;
use App\Models\Navigation;
use App\Repository\NavigationRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class NavigationController extends Controller
{

    public function __construct(public NavigationRepositoryInterface $navigationRepository)
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create navigations') || Gate::allows('edit navigations') || Gate::allows('delete navigations')), 403);

        $navigations = $this->navigationRepository->all();
        return $this->render('backend.navigations.index', compact('navigations'));
    }

    public function create(Request $request): View
    {
        abort_unless(Gate::allows('create navigations'), 403);

        return $this->render('backend.navigations.create');
    }

    public function store(NavigationDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create navigations'), 403);

        $machine_name = Str::snake($request->validated()['name']);
        if ($this->navigationRepository->create($request->validated() + ['machine_name' => $machine_name])) {
            $message = ['type' => 'Success', 'message' => 'Navigation has been created successfully'];
        }
        return redirect()->route('backend.navigations.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(Navigation $navigation, Request $request): View
    {
        abort_unless(Gate::allows('edit navigations'), 403);

        return $this->render('backend.navigations.create', compact('navigation'));
    }

    public function update(NavigationDataRequest $request, Navigation $navigation): RedirectResponse
    {
        abort_unless(Gate::allows('edit navigations'), 403);

        $data = $request->validated();
        if ($this->navigationRepository->update($navigation->id, $data)) {
            $message = ['type' => 'Success', 'message' => 'Navigation has been updated successfully'];
        }
        return redirect()->route('backend.navigations.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(Request $request, Navigation $navigation): RedirectResponse
    {
        abort_unless(Gate::allows('delete navigations'), 403);

        if ($this->navigationRepository->delete($navigation->id)) {
            $message = ['type' => 'Success', 'message' => 'Navigation has been deleted successfully'];
        }
        return redirect()->route('backend.navigations.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
}
