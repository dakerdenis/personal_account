<?php

namespace App\View\Components\Site\Partials;

use App\Models\Contact;
use App\Repository\ContactRepositoryInterface;
use App\Repository\GeneralSettingRepositoryInterface;
use App\Repository\NavigationRepositoryInterface;
use App\Settings\GeneralSettings;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Kalnoy\Nestedset\Collection;

class Header extends Component
{
    public Collection $menu;
    public Collection $sideMenu;
    public Collection $buttonMenu;
    public GeneralSettings $settings;
    public ?Contact $contact;

    public function __construct(
        private NavigationRepositoryInterface     $navigationRepository,
        private GeneralSettingRepositoryInterface $settingRepository,
        private ContactRepositoryInterface $contactRepository,
    )
    {
        $this->menu = $this->navigationRepository->getNavigationMenuItems('main_navigation');
        $this->sideMenu = $this->navigationRepository->getNavigationMenuItems('footer_navigation');
        $this->buttonMenu = $this->navigationRepository->getNavigationMenuItems('button_navigation');
        $this->settings = $this->settingRepository->get();
        $this->contact = $this->contactRepository->find(1);
    }

    public function render(): Application|Factory|View
    {
        return view('components.site.partials.header');
    }
}
