<?php

namespace App\Providers;

use App\Repository\ActivityRepositoryInterface;
use App\Repository\ArticleRepositoryInterface;
use App\Repository\BlockRepositoryInterface;
use App\Repository\BranchRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ComplaintRepositoryInterface;
use App\Repository\ComplaintStatusRepositoryInterface;
use App\Repository\ContactRepositoryInterface;
use App\Repository\DepartmentRepositoryInterface;
use App\Repository\Eloquent\ActivityRepository;
use App\Repository\Eloquent\ArticleRepository;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\BlockRepository;
use App\Repository\Eloquent\BranchRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ComplaintRepository;
use App\Repository\Eloquent\ComplaintStatusRepository;
use App\Repository\Eloquent\ContactRepository;
use App\Repository\Eloquent\DepartmentRepository;
use App\Repository\Eloquent\FaqRepository;
use App\Repository\Eloquent\FileModelRepository;
use App\Repository\Eloquent\FileRepository;
use App\Repository\Eloquent\GalleryRepository;
use App\Repository\Eloquent\InsuranceTypeRepository;
use App\Repository\Eloquent\ManagementRepository;
use App\Repository\Eloquent\MenuItemRepository;
use App\Repository\Eloquent\NavigationRepository;
use App\Repository\Eloquent\PartnerRepository;
use App\Repository\Eloquent\PermissionRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\RepeatableRepository;
use App\Repository\Eloquent\ReportGroupRepository;
use App\Repository\Eloquent\ReportYearRepository;
use App\Repository\Eloquent\RoleRepository;
use App\Repository\Eloquent\SlideRepository;
use App\Repository\Eloquent\SliderRepository;
use App\Repository\Eloquent\StaffRepository;
use App\Repository\Eloquent\StaticPageRepository;
use App\Repository\Eloquent\UsefulLinkRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\VacancyPlaceTitleRepository;
use App\Repository\Eloquent\VacancyRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\FaqRepositoryInterface;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\FileRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use App\Repository\GeneralSettingRepositoryInterface;
use App\Repository\InsuranceTypeRepositoryInterface;
use App\Repository\ManagementRepositoryInterface;
use App\Repository\MenuItemRepositoryInterface;
use App\Repository\NavigationRepositoryInterface;
use App\Repository\PartnerRepositoryInterface;
use App\Repository\PermissionRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\RepeatableRepositoryInterface;
use App\Repository\ReportGroupRepositoryInterface;
use App\Repository\ReportYearRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\SettingRepositoryInterface;
use App\Repository\Settings\GeneralSettingRepository;
use App\Repository\Settings\SettingRepository;
use App\Repository\SlideRepositoryInterface;
use App\Repository\SliderRepositoryInterface;
use App\Repository\StaffRepositoryInterface;
use App\Repository\StaticPageRepositoryInterface;
use App\Repository\UsefulLinkRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\VacancyPlaceTitleRepositoryInterface;
use App\Repository\VacancyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
        $this->app->bind(NavigationRepositoryInterface::class, NavigationRepository::class);
        $this->app->bind(MenuItemRepositoryInterface::class, MenuItemRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(StaticPageRepositoryInterface::class, StaticPageRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(GeneralSettingRepositoryInterface::class, GeneralSettingRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SliderRepositoryInterface::class, SliderRepository::class);
        $this->app->bind(SlideRepositoryInterface::class, SlideRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(GalleryRepositoryInterface::class, GalleryRepository::class);
        $this->app->bind(BlockRepositoryInterface::class, BlockRepository::class);
        $this->app->bind(RepeatableRepositoryInterface::class, RepeatableRepository::class);
        $this->app->bind(FileModelRepositoryInterface::class, FileModelRepository::class);
        $this->app->bind(UsefulLinkRepositoryInterface::class, UsefulLinkRepository::class);
        $this->app->bind(ReportYearRepositoryInterface::class, ReportYearRepository::class);
        $this->app->bind(ReportGroupRepositoryInterface::class, ReportGroupRepository::class);
        $this->app->bind(ManagementRepositoryInterface::class, ManagementRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(FaqRepositoryInterface::class, FaqRepository::class);
        $this->app->bind(VacancyPlaceTitleRepositoryInterface::class, VacancyPlaceTitleRepository::class);
        $this->app->bind(VacancyRepositoryInterface::class, VacancyRepository::class);
        $this->app->bind(InsuranceTypeRepositoryInterface::class, InsuranceTypeRepository::class);
        $this->app->bind(PartnerRepositoryInterface::class, PartnerRepository::class);
        $this->app->bind(ComplaintStatusRepositoryInterface::class, ComplaintStatusRepository::class);
        $this->app->bind(ComplaintRepositoryInterface::class, ComplaintRepository::class);
    }

    public function boot()
    {
        //
    }
}
