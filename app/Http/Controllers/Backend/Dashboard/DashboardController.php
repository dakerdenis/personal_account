<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Http\Controllers\Backend\BackendController;
use App\Models\Category;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\ArticleRepositoryInterface;
use App\Repository\NavigationRepositoryInterface;
use App\Repository\VacancyRepositoryInterface;
use App\Services\InsureApiService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use stdClass;

class DashboardController extends BackendController
{

    public function __construct(
        public ActivityRepositoryInterface   $activityRepository,
        public NavigationRepositoryInterface $navigationRepository,
        private ArticleRepositoryInterface $articleRepository,
        private VacancyRepositoryInterface $vacancyRepository,
    )
    {

    }

    public function index(Request $request): View
    {
        $authLogs = $this->activityRepository->filterAndPaginate($request, 12, ['created_at', 'desc'], [['log_name', '=', 'auth']]);
        $contentLogs = $this->activityRepository->filterAndPaginate($request, 12, ['created_at', 'desc'], [['log_name', '=', 'content']]);
        return $this->render('backend.dashboard.index', compact('authLogs', 'contentLogs'));
    }

    public function sitemap(Request $request): View
    {
        abort_unless(Gate::allows('generate sitemap'), 403);

        $filename = 'sitemap.xml';
        $file = File::exists($filename);
        $fileData = null;
        if ($file) {
            $fileData = new stdClass();
            $fileData->name = $filename;
            $fileData->created_at = Carbon::createFromTimestamp(File::lastModified($filename))->diffForHumans();
        }

        return $this->render('backend.dashboard.sitemap', compact('fileData'));
    }

    public function generateSitemap(Request $request): RedirectResponse
    {
        abort_unless(Gate::allows('generate sitemap'), 403);

        $sitemap = App::make("sitemap");
        $structure = $this->navigationRepository->getNavigationMenuItemsFlat('footer_navigation');
        $buttonNavigationItem = $this->navigationRepository->getNavigationMenuItemsFlat('button_navigation')->first();
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $sitemap->add($key === 'az' ? url('/') : LaravelLocalization::getLocalizedURL($key, '/'), date('c', time()), '1.0', 'daily', [], null);
        }
        foreach ($structure as $item) {
            if ($item->slug != '#') {
                foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
                    $sitemap->add(
                        $item->slug === '/' ? customIndexUrl() : LaravelLocalization::getLocalizedURL($key, $item->slug),
                        date('c', time()),
                        $item->slug === '/' ? '1.0' : '0.9',
                        'monthly',
                        [],
                        null
                    );
                }
            }
        }

        if ($buttonNavigationItem) {
            foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
                $sitemap->add(LaravelLocalization::getLocalizedURL($key, $buttonNavigationItem->slug), date('c', time()), '0.8', 'monthly', [], null);
            }
        }
        $sitemap->store('xml');

        return redirect()->route('backend.dashboard.generate_sitemap')->with('message', $message ?? ['type' => 'Success', 'message' => 'Sitemap regenerated successfully']);
    }

    public function apiData()
    {
        abort_unless(Gate::allows('access api data'), 403);

        $data = Cache::get('insureapi');
        $doctorsSpecialities = Cache::get('insureapi_doctors');

        return $this->render('backend.dashboard.api-data', compact('data', 'doctorsSpecialities'));
    }
    public function updateApiDataCasco(InsureApiService $insureApiService)
    {
        abort_unless(Gate::allows('access api data'), 403);

        Cache::forget('insureapi');
        $insureApiService->getBrandList();
        $insureApiService->getProductionYears();
        $insureApiService->getRepairShops();
        $insureApiService->getFranchises();
        $insureApiService->getDrivers();
        $insureApiService->getInstallments();
        $insureApiService->getBonuses();

        return redirect()->route('backend.api-data')->with('message', $message ?? ['type' => 'Success', 'message' => 'Api data updated successfully']);
    }
    public function updateApiDataDoctors(InsureApiService $insureApiService)
    {
        abort_unless(Gate::allows('access api data'), 403);

        Cache::forget('insureapi_doctors');
        $insureApiService->getSpecialities();
        $insureApiService->updateDoctors();

        return redirect()->route('backend.api-data')->with('message', $message ?? ['type' => 'Success', 'message' => 'Api data updated successfully']);
    }
}
