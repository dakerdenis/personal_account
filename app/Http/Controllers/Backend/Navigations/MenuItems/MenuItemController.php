<?php

namespace App\Http\Controllers\Backend\Navigations\MenuItems;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MenuItemDataRequest;
use App\Models\MenuItem;
use App\Models\Navigation;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\MenuItemRepositoryInterface;
use App\Repository\NavigationRepositoryInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{

    /**
     * MenuItemController constructor.
     * @param ActivityRepositoryInterface $activityRepository
     * @param NavigationRepositoryInterface $navigationRepository
     * @param MenuItemRepositoryInterface $menuItemRepository
     */
    public function __construct(
        private ActivityRepositoryInterface   $activityRepository,
        private NavigationRepositoryInterface $navigationRepository,
        private MenuItemRepositoryInterface   $menuItemRepository)
    {
    }

    public function index(Request $request, Navigation $navigation): View
    {
        $menu_items = $this->navigationRepository->getNavigationMenuItemsAll($navigation->machine_name);
        return $this->render('backend.navigations.menu_items.index', compact('navigation', 'menu_items'));
    }

    public function create(Request $request, Navigation $navigation): View
    {
        $menu_items = $this->navigationRepository->getNavigationMenuItemsAll($navigation->machine_name);
        return $this->render('backend.navigations.menu_items.create', compact('navigation', 'menu_items'));
    }

    public function store(MenuItemDataRequest $request, Navigation $navigation): RedirectResponse
    {
        if ($menu_item = $this->menuItemRepository->create($request->validated() + ['navigation_id' => $navigation->id])) {
            $message = ['type' => 'Success', 'message' => 'Menu Item has been created successfully'];
            $this->activityRepository->log('content', $menu_item, ['route_name' => 'backend.navigations.menu_items.edit', 'parameter' => 'menu_item', 'parameter_2_name' => 'navigation', 'parameter_2' => $navigation->machine_name, 'title' => $menu_item->title], MenuItem::$created);
        }
        return redirect()->route('backend.navigations.menu_items.index', ['navigation' => $navigation->machine_name])->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }


    /**
     * @param Request $request
     * @param Navigation $navigation
     * @param MenuItem $menu_item
     * @return View
     */
    public function edit(Request $request, Navigation $navigation, MenuItem $menu_item): View
    {
        $menu_items = $this->navigationRepository->getNavigationMenuItemsAll($navigation->machine_name);
        return $this->render('backend.navigations.menu_items.create', compact('navigation', 'menu_items', 'menu_item'));
    }

    /**
     * @param MenuItemDataRequest $request
     * @param Navigation $navigation
     * @param MenuItem $menu_item
     * @return RedirectResponse
     */
    public function update(MenuItemDataRequest $request, Navigation $navigation, MenuItem $menu_item): RedirectResponse
    {
        $data = $request->validated();
        if ($this->menuItemRepository->update($menu_item->id, $data + ['navigation_id' => $navigation->id])) {
            $message = ['type' => 'Success', 'message' => 'Menu Item has been updated successfully'];
            $this->activityRepository->log('content', $menu_item, ['route_name' => 'backend.navigations.menu_items.edit', 'parameter' => 'menu_item', 'parameter_2_name' => 'navigation', 'parameter_2' => $navigation->machine_name, 'title' => $menu_item->title], MenuItem::$updated);
        }
        return redirect()->route('backend.navigations.menu_items.index', ['navigation' => $navigation->machine_name])->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    /**
     * @param Request $request
     * @param Navigation $navigation
     * @param MenuItem $menu_item
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, Navigation $navigation, MenuItem $menu_item): RedirectResponse
    {
        $title = $menu_item->title;
        if ($this->menuItemRepository->delete($menu_item->id)) {
            $message = ['type' => 'Success', 'message' => 'Menu Item has been deleted successfully'];
            $this->activityRepository->log('content', $menu_item, ['title' => $title], MenuItem::$deleted);
        }
        return redirect()->route('backend.navigations.menu_items.index', ['navigation' => $navigation->machine_name])->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    /**
     * @param Request $request
     * @param Navigation $navigation
     * @return View
     */
    public function reorderView(Request $request, Navigation $navigation): View
    {
        $menu_items = $this->navigationRepository->getNavigationMenuItemsAll($navigation->machine_name);
        return $this->render('backend.navigations.menu_items.reorder', compact('menu_items', 'navigation'));
    }

    /**
     * @param Request $request
     * @param Navigation $navigation
     * @return bool
     */
    public function reorder(Request $request, Navigation $navigation): bool
    {
        return $this->menuItemRepository->reorder($request);
    }


    /**
     * @param Request $request
     * @param Navigation $navigation
     * @param MenuItem $menu_item
     */
    public function toggleActivate(Request $request, Navigation $navigation, MenuItem $menu_item)
    {
        if ($request->has('active')) {
            $active = (boolean)$request->post('active');
            $this->menuItemRepository->update($menu_item->id, ['active' => $active]);
            $this->activityRepository->log('content', $menu_item, ['route_name' => 'backend.navigations.menu_items.edit', 'parameter' => 'menu_item', 'parameter_2_name' => 'navigation', 'parameter_2' => $navigation->machine_name, 'title' => $menu_item->title], $active ? MenuItem::$activated : MenuItem::$deactivated);
        }
    }
}
