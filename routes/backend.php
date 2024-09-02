<?php

use App\Http\Controllers\Backend\Articles\ArticleController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Blocks\BlockController;
use App\Http\Controllers\Backend\Branches\BranchController;
use App\Http\Controllers\Backend\Categories\CategoryController;
use App\Http\Controllers\Backend\Complaints\ComplaintController;
use App\Http\Controllers\Backend\Complaints\Statuses\ComplaintStatusController;
use App\Http\Controllers\Backend\Contacts\ContactController;
use App\Http\Controllers\Backend\Dashboard\DashboardController;
use App\Http\Controllers\Backend\Departments\DepartmentController;
use App\Http\Controllers\Backend\Faqs\FaqController;
use App\Http\Controllers\Backend\Files\FileController;
use App\Http\Controllers\Backend\Files\FileModelController;
use App\Http\Controllers\Backend\Galleries\GalleryController;
use App\Http\Controllers\Backend\InsuranceTypes\InsuranceTypeController;
use App\Http\Controllers\Backend\Managers\ManagerController;
use App\Http\Controllers\Backend\Navigations\MenuItems\MenuItemController;
use App\Http\Controllers\Backend\Navigations\NavigationController;
use App\Http\Controllers\Backend\Partners\PartnerController;
use App\Http\Controllers\Backend\Products\ProductController;
use App\Http\Controllers\Backend\Reports\Groups\ReportGroupController;
use App\Http\Controllers\Backend\Reports\Years\ReportYearController;
use App\Http\Controllers\Backend\Roles\RoleController;
use App\Http\Controllers\Backend\Settings\SettingController;
use App\Http\Controllers\Backend\Sliders\SlideController;
use App\Http\Controllers\Backend\Sliders\SliderController;
use App\Http\Controllers\Backend\Staff\StaffController;
use App\Http\Controllers\Backend\StaticPages\StaticPageController;
use App\Http\Controllers\Backend\UsefulLinks\UsefulLinkController;
use App\Http\Controllers\Backend\Vacancies\VacancyController;
use App\Http\Controllers\Backend\Vacancies\VacancyPlaceTitleController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:staff')->name('login');
Route::post('login', [LoginController::class, 'store'])->middleware('guest:staff')->name('login');
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth:staff')->name('logout');

Route::middleware(['auth:staff', 'backend_menu'])->group(function () {
    //Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('sitemap_generate', [DashboardController::class, 'sitemap'])->name('generate_sitemap');
        Route::post('sitemap_generate', [DashboardController::class, 'generateSitemap'])->name('generate_sitemap');
        Route::get('change_theme', [DashboardController::class, 'changeTheme'])->name('change_theme');
    });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Navigations
    Route::prefix('navigations/{navigation:machine_name}/menu_items')->name('navigations.menu_items.')->group(function () {
        Route::get('', [MenuItemController::class, 'index'])->name('index');
        Route::get('create', [MenuItemController::class, 'create'])->name('create');
        Route::get('{menu_item}/edit', [MenuItemController::class, 'edit'])->name('edit');
        Route::put('{menu_item}/update', [MenuItemController::class, 'update'])->name('update');
        Route::delete('{menu_item}/delete', [MenuItemController::class, 'destroy'])->name('destroy');
        Route::post('create', [MenuItemController::class, 'store'])->name('store');
        Route::get('reorder', [MenuItemController::class, 'reorderView'])->name('reorder-view');
        Route::post('reorder', [MenuItemController::class, 'reorder'])->name('reorder');
        Route::post('{menu_item}/toggle_activate', [MenuItemController::class, 'toggleActivate'])->name('toggle_activate');
    });
    Route::resource('navigations', NavigationController::class);

    //Categories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::post('toggle_activate/{category}', [CategoryController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [CategoryController::class, 'reorderView'])->name('reorder-view');
        Route::post('reorder', [CategoryController::class, 'reorder'])->name('reorder');
    });
    Route::resource('categories', CategoryController::class);

    //Static Pages
    Route::prefix('static_pages')->name('static_pages.')->group(function () {
        Route::post('toggle_activate/{static_page}', [StaticPageController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [StaticPageController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [StaticPageController::class, 'reorder']);
    });
    Route::resource('static_pages', StaticPageController::class);

    //Faqs
    Route::prefix('faq_entities')->name('faq_entities.')->group(function () {
        Route::post('toggle_activate/{faq_entity}', [FaqController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [FaqController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [FaqController::class, 'reorder']);
    });
    Route::resource('faq_entities', FaqController::class);

    //InsuranceTypes
    Route::prefix('insurance_types')->name('insurance_types.')->group(function () {
        Route::post('toggle_activate/{insurance_type}', [InsuranceTypeController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [InsuranceTypeController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [InsuranceTypeController::class, 'reorder']);
    });
    Route::resource('insurance_types', InsuranceTypeController::class);

    //Managers
    Route::prefix('managers')->name('managers.')->group(function () {
        Route::post('toggle_activate/{manager}', [ManagerController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [ManagerController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [ManagerController::class, 'reorder']);
    });
    Route::resource('managers', ManagerController::class);

    //Branches
    Route::prefix('branches')->name('branches.')->group(function () {
        Route::post('toggle_activate/{branch}', [BranchController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [BranchController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [BranchController::class, 'reorder']);
    });
    Route::resource('branches', BranchController::class);

    //Partners
    Route::prefix('partners')->name('partners.')->group(function () {
        Route::post('toggle_activate/{partner}', [PartnerController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [PartnerController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [PartnerController::class, 'reorder']);
    });
    Route::resource('partners', PartnerController::class);

    //Departments
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::post('toggle_activate/{department}', [DepartmentController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [DepartmentController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [DepartmentController::class, 'reorder']);
    });
    Route::resource('departments', DepartmentController::class);

    //Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::post('toggle_activate/{product}', [ProductController::class, 'toggleActive'])->name('toggle_activate');
        Route::post('get_insurance_block', [ProductController::class, 'getInsuranceBlock'])->name('get-insurance-block');
        Route::post('get_feature_block', [ProductController::class, 'getFeatureBlock'])->name('get-feature-block');
        Route::post('get_feature_line_block/{featureId}', [ProductController::class, 'getFeatureLineBlock'])->name('get-feature-line-block');
        Route::post('get_faq_block', [ProductController::class, 'getFaqBlock'])->name('get-faq-block');
        Route::get('reorder', [ProductController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [ProductController::class, 'reorder']);
    });
    Route::resource('products', ProductController::class);

    //Contacts
    Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('contacts/{contact}/edit', [ContactController::class, 'update'])->name('contacts.update');

    //Settings
    Route::get('settings', SettingController::class)->name('settings');
    Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');

    //Roles
    Route::get('roles/clear_cache', [RoleController::class, 'clearCache']);
    Route::resource('roles', RoleController::class);

    //Staff
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('archive', [StaffController::class, 'archive'])->name('archive');
        Route::get('restore/{staff}', [StaffController::class, 'restore'])->name('restore');
    });
    Route::resource('staff', StaffController::class);

    //UsefulLinks
    Route::resource('useful_links', UsefulLinkController::class);

    //ReportGroups
    Route::prefix('report_groups')->name('report_groups.')->group(function () {
        Route::post('toggle_activate/{report_group}', [ReportGroupController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [ReportGroupController::class, 'reorderView'])->name('reorder');
        Route::post('reorder', [ReportGroupController::class, 'reorder']);
    });
    Route::resource('report_groups', ReportGroupController::class);

    //ReportYears
    Route::prefix('report_years')->name('report_years.')->group(function () {
        Route::post('toggle_activate/{report_year}', [ReportYearController::class, 'toggleActive'])->name('toggle_activate');
    });
    Route::resource('report_years', ReportYearController::class);

    //Complaint Statuses
    Route::resource('complaint_statuses', ComplaintStatusController::class);
    Route::resource('complaints', ComplaintController::class);

    //Articles
    Route::prefix('articles')->name('articles.')->group(function () {
        Route::post('toggle_activate/{article}', [ArticleController::class, 'toggleActive'])->name('toggle_activate');
        Route::get('reorder', [ArticleController::class, 'reorderView'])->name('reorder-view');
        Route::post('reorder', [ArticleController::class, 'reorder'])->name('reorder');
    });
    Route::resource('articles', ArticleController::class);

    //Galleries
    Route::prefix('galleries')->name('galleries.')->group(function () {
        Route::post('toggle_activate/{gallery}', [GalleryController::class, 'toggleActive'])->name('toggle_activate');
        Route::post('{gallery}/add_images', [GalleryController::class, 'addImages'])->name('add_images');
    });
    Route::resource('galleries', GalleryController::class);

    //Galleries
    Route::prefix('file')->name('file.')->group(function () {
        Route::post('toggle_activate/{file}', [FileModelController::class, 'toggleActive'])->name('toggle_activate');
    });
    Route::resource('file', FileModelController::class);

    //Files
    Route::prefix('files')->name('files.')->group(function () {
        Route::post('upload_image', [FileController::class, 'uploadImage']);
        Route::post('upload_fancy_image', [FileController::class, 'uploadFancyImage']);
    });

    //Blocks
    Route::prefix('blocks')->name('blocks.')->group(function () {
        Route::get('select_type', [BlockController::class, 'selectType'])->name('select_type');
        Route::get('/main_page_blocks', [BlockController::class, 'mainPageBlocks'])->name('main_page_blocks');
        Route::post('/main_page_blocks', [BlockController::class, 'updateMainPageBlocks']);
        Route::get('/category_blocks', [BlockController::class, 'categoryBlocks'])->name('category_blocks');
        Route::post('/category_blocks', [BlockController::class, 'updateCategoryBlocks']);
        Route::post('/select_block_line', [BlockController::class, 'selectBlockLine'])->name('select_block_line');
        Route::get('/search_block', [BlockController::class, 'searchBlock'])->name('search_block');
        Route::get('get_product_block', [BlockController::class, 'getProductBlock'])->name('get-product-block');
        Route::post('store_cards', [BlockController::class, 'storeCards'])->name('store_cards');
        Route::post('add_card', [BlockController::class, 'addCard'])->name('add_card');
        Route::post('add_card_link', [BlockController::class, 'addCardLink'])->name('add_card_link');
        Route::post('add_extended_stat', [BlockController::class, 'addExtendedStat'])->name('add_extended_stat');
        Route::post('add_extended_stat_info', [BlockController::class, 'addExtendedStatInfo'])->name('add_extended_stat_info');
        Route::put('update_cards/{block}', [BlockController::class, 'updateCards'])->name('update_cards');
    });
    Route::resource('blocks', BlockController::class);

    //Sliders
    Route::resource('sliders', SliderController::class);
    Route::post('get_link_block/{slideId}', [SlideController::class, 'getLinkBlock'])->name('slide.get-link-block');
    Route::prefix('sliders/{slider:machine_name}/slides')->name('sliders.slides.')->group(function () {
        Route::get('', [SliderController::class, 'index'])->name('index');
        Route::get('create', [SlideController::class, 'create'])->name('create');
        Route::post('create', [SlideController::class, 'store'])->name('store');
        Route::post('get_empty_slide', [SlideController::class, 'getEmptySlide'])->name('get_empty_slide');
    });


    //VacancyPlaceTitles
    Route::resource('vacancy_place_titles', VacancyPlaceTitleController::class);

    //Vacancies
    Route::resource('vacancies', VacancyController::class);

    Route::get('apis/data', [DashboardController::class, 'apiData'])->name('api-data');
    Route::post('apis/data_casco', [DashboardController::class, 'updateApiDataCasco'])->name('api-data-casco');
    Route::post('apis/data_doctors', [DashboardController::class, 'updateApiDataDoctors'])->name('api-data-doctors');
});
