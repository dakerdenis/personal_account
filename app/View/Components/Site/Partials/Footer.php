<?php

namespace App\View\Components\Site\Partials;

use App\Models\Contact;
use App\Repository\ContactRepositoryInterface;
use App\Repository\GeneralSettingRepositoryInterface;
use App\Repository\NavigationRepositoryInterface;
use App\Settings\GeneralSettings;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Kalnoy\Nestedset\Collection;

class Footer extends Component
{

    public Collection $menu;
    public Collection $buttonMenu;
    public GeneralSettings $settings;
    public ?Contact $contacts;

    public function __construct(
        private NavigationRepositoryInterface     $navigationRepository,
        private GeneralSettingRepositoryInterface $settingRepository,
        private ContactRepositoryInterface        $contactRepository,
    )
    {
        $this->menu = $this->navigationRepository->getNavigationMenuItems('footer_navigation');
        $this->buttonMenu = $this->navigationRepository->getNavigationMenuItems('button_navigation');
        $this->settings = $this->settingRepository->get();
        $this->contacts = $this->contactRepository->find(1);
    }

    public function render(): View|Factory|Htmlable|string|Closure|Application
    {
        return view('components.site.partials.footer');
    }
}
