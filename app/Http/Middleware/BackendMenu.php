<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class BackendMenu
{
    public function handle(Request $request, Closure $next): mixed
    {
        $structure = $this->getStructure($request);
        Menu::macro('main', function () use ($structure) {
            $wrapper_menu = Menu::new()->withoutWrapperTag();
            $user = Auth::user();
            $i = 0;
            foreach ($structure as $item) {
                if (!isset($item['permissions']) || $user->hasRole('admin') || $user->hasAnyPermission($item['permissions'])) {
                    if ($item['route']) $wrapper_menu->add(Link::toRoute($item['route'], Html::raw("<i data-feather='{$item['icon']}'></i><span>{$item['title']}</span>")->render())->addClass('sidebar-link sidebar-title')->setAttribute('target', $i === 0 ? '_blank' : '_self'));
                    else {
                        if ($item['children']) {
                            $sub_menu = Menu::new()->addClass('sidebar-submenu')->setParentAttributes(['class' => 'sidebar-list']);
                            foreach ($item['children'] as $child) {
                                if (!isset($child['permissions']) || $user->hasRole('admin') || $user->hasAllPermissions($child['permissions'])) {
                                    $sub_menu->add(Link::toRoute($child['route'], Html::raw("{$child['title']}")->render(), $child['parameters'] ?? null));
                                }
                            }
                            $wrapper_menu->submenu(Html::raw('<a class="sidebar-link sidebar-title" href="#"><i data-feather="' . $item['icon'] . '"></i><span>' . $item['title'] . '</span></a>')->render(), $sub_menu);
                        }
                    }
                }
                $i++;
            }
            return $wrapper_menu;
        });
        return $next($request);
    }

    protected function getStructure(Request $request): array
    {
        return [
            ['title' => 'Go to Site', 'icon' => 'arrow-right', 'route' => 'index', 'children' => null],
            ['title' => 'Dashboard', 'icon' => 'home', 'route' => 'backend.dashboard', 'children' => null],
            ['title' => 'Navigation', 'icon' => 'menu', 'route' => null, 'permissions' => ['edit navigations', 'create navigations'], 'children' => [
                    ['title' => 'List all', 'route' => 'backend.navigations.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create navigation', 'route' => 'backend.navigations.create', 'parameters' => null, 'children' => null],
                ] + ($request->routeIs('backend.navigations.edit') ? [2 => ['title' => 'Edit navigation', 'route' => 'backend.navigations.edit', 'parameters' => $request->route('navigation')->id, 'children' => null]] : [])
            ],
            ['title' => 'Categories', 'icon' => 'folder', 'route' => null, 'permissions' => ['edit categories', 'create categories'], 'children' => [
                    ['title' => 'List all', 'route' => 'backend.categories.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create category', 'route' => 'backend.categories.create', 'parameters' => null, 'children' => null],
                    ['title' => 'Reorder', 'route' => 'backend.categories.reorder', 'parameters' => null, 'children' => null],
                ] + ($request->routeIs('backend.categories.edit') ? [3 => ['title' => 'Edit category', 'route' => 'backend.categories.edit', 'parameters' => $request->route('category')->id, 'children' => null]] : [])
            ],
            ['title' => 'Products', 'icon' => 'briefcase', 'route' => null, 'permissions' => ['edit products', 'create products'], 'children' => [
                    ['title' => 'List all', 'route' => 'backend.products.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create product', 'route' => 'backend.products.create', 'parameters' => null, 'children' => null],
                    ['title' => 'Reorder', 'route' => 'backend.products.reorder', 'parameters' => null, 'children' => null],
                ] + ($request->routeIs('backend.products.edit') ? [3 => ['title' => 'Edit product', 'route' => 'backend.products.edit', 'parameters' => $request->route('product')->id, 'children' => null]] : [])
            ],
            ['title' => 'Managers', 'icon' => 'users', 'route' => null, 'permissions' => ['edit managers', 'create managers'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.managers.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Manager', 'route' => 'backend.managers.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.managers.edit') ? [ 2 => ['title' => 'Edit Manager', 'route' => 'backend.managers.edit', 'parameters' => $request->route('manager')->id, 'children' => null]] : [])
            ],
            ['title' => 'Branches', 'icon' => 'home', 'route' => null, 'permissions' => ['edit branches', 'create branches'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.branches.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Branch', 'route' => 'backend.branches.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.branches.edit') ? [ 2 => ['title' => 'Edit Branch', 'route' => 'backend.branches.edit', 'parameters' => $request->route('branch')->id, 'children' => null]] : [])
            ],
            ['title' => 'Departments', 'icon' => 'sidebar', 'route' => null, 'permissions' => ['edit departments', 'create departments'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.departments.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Department', 'route' => 'backend.departments.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.departments.edit') ? [ 2 => ['title' => 'Edit Department', 'route' => 'backend.departments.edit', 'parameters' => $request->route('department')->id, 'children' => null]] : [])
            ],
            ['title' => 'Reports', 'icon' => 'flag', 'route' => null, 'permissions' => ['edit reports data', 'create reports data'],  'children' => [
                    ['title' => 'Groups', 'route' => 'backend.report_groups.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Years', 'route' => 'backend.report_years.index', 'parameters' => null, 'children' => null],
                ] + ( $request->routeIs('backend.file.edit') ? [ 2 => ['title' => 'Edit File', 'route' => 'backend.file.edit', 'parameters' => $request->route('file')->id, 'children' => null]] : [])
            ],
            ['title' => 'Files', 'icon' => 'download', 'route' => null, 'permissions' => ['edit files', 'create files'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.file.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create File', 'route' => 'backend.file.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.file.edit') ? [ 2 => ['title' => 'Edit File', 'route' => 'backend.file.edit', 'parameters' => $request->route('file')->id, 'children' => null]] : [])
            ],
            ['title' => 'Partners', 'icon' => 'sun', 'route' => null, 'permissions' => ['edit partners', 'create partners'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.partners.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create partner', 'route' => 'backend.partners.create', 'parameters' => null , 'children' => null],
                    ['title' => 'Reorder partners', 'route' => 'backend.partners.reorder', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.partners.edit') ? [ 2 => ['title' => 'Edit partner', 'route' => 'backend.partners.edit', 'parameters' => $request->route('partner')->id, 'children' => null]] : [])
            ],
            ['title' => 'Articles', 'icon' => 'book-open', 'route' => null, 'permissions' => ['edit articles', 'create articles'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.articles.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Article', 'route' => 'backend.articles.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.articles.edit') ? [ 2 => ['title' => 'Edit Article', 'route' => 'backend.articles.edit', 'parameters' => $request->route('article')->id, 'children' => null]] : [])
            ],
            ['title' => 'Vacancies', 'icon' => 'inbox', 'route' => null, 'permissions' => ['edit vacancies', 'create vacancies'], 'children' => [
                    ['title' => 'List all', 'route' => 'backend.vacancies.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create vacancy', 'route' => 'backend.vacancies.create', 'parameters' => null, 'children' => null],
                    ['title' => 'Place Titles', 'route' => 'backend.vacancy_place_titles.index', 'parameters' => null, 'children' => null],
                ] + ($request->routeIs('backend.vacancies.edit') ? [3 => ['title' => 'Edit vacancy', 'route' => 'backend.vacancies.edit', 'parameters' => $request->route('vacancy')->id, 'children' => null]] : [])
            ],
            ['title' => 'Static Pages', 'icon' => 'file', 'route' => null, 'permissions' => ['edit static pages', 'create static pages'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.static_pages.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Page', 'route' => 'backend.static_pages.create', 'parameters' => null , 'children' => null],
                    ['title' => 'Reorder Pages', 'route' => 'backend.static_pages.reorder', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.static_pages.edit') ? [ 2 => ['title' => 'Edit Page', 'route' => 'backend.static_pages.edit', 'parameters' => $request->route('static_page')->id, 'children' => null]] : [])
            ],
            ['title' => 'FAQs', 'icon' => 'file', 'route' => null, 'permissions' => ['edit faqs', 'create faqs'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.faq_entities.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Faq', 'route' => 'backend.faq_entities.create', 'parameters' => null , 'children' => null],
                    ['title' => 'Reorder Faqs', 'route' => 'backend.faq_entities.reorder', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.faq_entities.edit') ? [ 2 => ['title' => 'Edit Faq', 'route' => 'backend.faq_entities.edit', 'parameters' => $request->route('faq_entity')->id, 'children' => null]] : [])
            ],
            //['title' => 'Complaints', 'icon' => 'mail', 'route' => null, 'permissions' => ['edit complaints'],  'children' => [
            //        ['title' => 'List all', 'route' => 'backend.complaints.index', 'parameters' => null, 'children' => null],
            //        ['title' => 'Statuses', 'route' => 'backend.complaint_statuses.index', 'parameters' => null, 'children' => null],
            //    ] + ( $request->routeIs('backend.faq_entities.edit') ? [ 2 => ['title' => 'Edit Faq', 'route' => 'backend.faq_entities.edit', 'parameters' => $request->route('faq_entity')->id, 'children' => null]] : [])
            //],
            ['title' => 'Sliders', 'icon' => 'fast-forward', 'route' => null, 'permissions' => ['manage sliders'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.sliders.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Slider', 'route' => 'backend.sliders.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.sliders.edit') ? [ 2 => ['title' => 'Edit Slider', 'route' => 'backend.sliders.edit', 'parameters' => $request->route('slider')->id, 'children' => null]] : [])
            ],
            ['title' => 'Blocks', 'icon' => 'box', 'route' => null, 'permissions' => ['edit blocks', 'create blocks'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.blocks.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Block', 'route' => 'backend.blocks.select_type', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.blocks.edit') ? [ 2 => ['title' => 'Edit Block', 'route' => 'backend.blocks.edit', 'parameters' => $request->route('block')->id, 'children' => null]] : [])
                + [3 => ['title' => 'Main Page Blocks', 'route' => 'backend.blocks.main_page_blocks', 'parameters' => null , 'children' => null]]
            ],
            ['title' => 'Useful Links', 'icon' => 'link-2', 'route' => null, 'permissions' => ['edit useful_links', 'create useful_links'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.useful_links.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Link', 'route' => 'backend.useful_links.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.useful_links.edit') ? [ 2 => ['title' => 'Edit Link', 'route' => 'backend.useful_links.edit', 'parameters' => $request->route('useful_link')->id, 'children' => null]] : [])
            ],
            ['title' => 'Insurance types', 'icon' => 'copy', 'route' => null, 'permissions' => ['edit insurance_types', 'create insurance_types'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.insurance_types.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Insurance type', 'route' => 'backend.insurance_types.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.insurance_types.edit') ? [ 2 => ['title' => 'Edit Insurance type', 'route' => 'backend.insurance_types.edit', 'parameters' => $request->route('insurance_type')->id, 'children' => null]] : [])
            ],
            ['title' => 'Galleries', 'icon' => 'image', 'route' => null, 'permissions' => ['edit galleries', 'create galleries'],  'children' => [
                    ['title' => 'List all', 'route' => 'backend.galleries.index', 'parameters' => null, 'children' => null],
                    ['title' => 'Create Gallery', 'route' => 'backend.galleries.create', 'parameters' => null , 'children' => null],
                ] + ( $request->routeIs('backend.galleries.edit') ? [ 2 => ['title' => 'Edit Gallery', 'route' => 'backend.galleries.edit', 'parameters' => $request->route('gallery')->id, 'children' => null]] : [])
            ],
            ['title' => 'Roles & Permissions', 'icon' => 'user-check', 'route' => null, 'permissions' => ['manage roles'], 'children' => [
                ['title' => 'Roles', 'route' => 'backend.roles.index', 'parameters' => null, 'children' => null],
                ['title' => 'Create role', 'route' => 'backend.roles.create', 'parameters' => null, 'children' => null],
            ]],
            ['title' => 'Staff', 'icon' => 'user-plus', 'route' => null, 'permissions' => ['manage roles'], 'children' => [
                ['title' => 'List all', 'route' => 'backend.staff.index', 'parameters' => null, 'children' => null],
                ['title' => 'Archive', 'route' => 'backend.staff.archive', 'parameters' => null, 'children' => null],
                ['title' => 'Create staff', 'route' => 'backend.staff.create', 'parameters' => null, 'children' => null],
            ]],
        ];
    }
}
