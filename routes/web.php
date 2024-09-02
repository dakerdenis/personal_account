<?php

use App\Http\Controllers\Site\PageController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('az/medecine-insurance/', [PageController::class, 'redirectMedecineInsurance'])->name('redirect-medecine-insurance');
Route::get('ru/медицинское-страхование/', [PageController::class, 'redirectMedecineInsuranceRu'])->name('redirect-medecine-insurance-ru');
Route::get('ru/автомобильное-страхование/', [PageController::class, 'redirectAutoInsuranceRu'])->name('redirect-auto-insurance-ru');
Route::get('az/auto-insurance/', [PageController::class, 'redirectAutoInsurance'])->name('redirect-auto-insurance');
Route::get('az/about-us/', [PageController::class, 'redirectAboutUs'])->name('redirect-about-us-insurance');
Route::get('ru/faq-о-компании/', [PageController::class, 'redirectAboutUsRu'])->name('redirect-about-us-ru');
Route::get('az/health-insurance-packages/', [PageController::class, 'redirectHealthInsurancePackages'])->name('redirect-health-insurance-packages');
Route::get('ru/пакеты-медицинского-страхования/', [PageController::class, 'redirectHealthInsurancePackagesRu'])->name('redirect-health-insurance-packages-2');
Route::get('az/medecine-insurance-cost-personal/', [PageController::class, 'redirectHealthInsurancePackages'])->name('redirect-health-insurance-packages-ru');
Route::get('ru/рассчитать-стоимость-медицинского-с/', [PageController::class, 'redirectHealthInsurancePackagesRu'])->name('redirect-health-insurance-packages-2-ru');

Route::post('submit_product_form/{product}', [PageController::class, 'submitProductForm'])->name('submit-product-form');
Route::get('/az', [PageController::class, 'redirectNoLocale'])->name('redirectNoLocale');
Route::get('{locale?}', [PageController::class, 'index'])->where('locale', 'ru')->name('index');
Route::group(
    [
      
  'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::post('submit_vacancy_form', [PageController::class, 'sendVacancy'])->name('send-vacancy-form');
        Route::post('submit_case_happened_form', [PageController::class, 'submitCaseHappenedForm'])->name('submit-case-happened-form');
        Route::post('submit_complaint_form', [PageController::class, 'submitComplaintForm'])->name('submit-complaint-form');
        Route::post('check_complaint_form', [PageController::class, 'checkComplaintForm'])->name('check-complaint-form');
        Route::post('casco/calculate', [PageController::class, 'cascoCalculate'])->name('casco-calculate');
        Route::post('casco/send', [PageController::class, 'cascoSend'])->name('casco-send');
        Route::post('personal_insurance/calculate', [PageController::class, 'personalInsuranceCalculate'])->name('personal-insurance-calculate');
        Route::post('personal_insurance/send', [PageController::class, 'personalInsuranceSend'])->name('personal-insurance-send');
        Route::get('sitemap', [PageController::class, 'sitemap'])->name('sitemap');
        Route::get('contacts', [PageController::class, 'contacts'])->name('contacts');
        Route::post('contacts', [PageController::class, 'sendContactForm'])->name('send-contact-form');
        Route::get('search', [PageController::class, 'search'])->name('search');
        Route::get('search/other', [PageController::class, 'searchOther'])->name('search-other');
        Route::get('pages/{staticPage:slug}', [PageController::class, 'staticPage'])->name('static-page');
        Route::get('/{category:slug}/article/{article:slug}', [PageController::class, 'article'])->name('article')->where('category', '.*');
        Route::get('/{category:slug}/product/{product:slug}', [PageController::class, 'product'])->name('product')->where('category', '.*');
        Route::get('/{category:slug}/vacancy/{vacancy:slug}', [PageController::class, 'vacancy'])->name('vacancy');
        Route::get('/{category:slug}/speciality/{id}', [PageController::class, 'speciality'])->name('speciality');
        Route::get('/{category:slug}/doctor/{id}', [PageController::class, 'doctor'])->name('doctor');
        Route::get('/{category:slug}', [PageController::class, 'category'])->name('category')->where('category', '.*');
    }
);
