<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\Site\CalculateCascoRequest;
use App\Http\Requests\Site\CalculatePersonalInsuranceRequest;
use App\Http\Requests\Site\CaseHappenedFormData;
use App\Http\Requests\Site\CheckComplaintFormData;
use App\Http\Requests\Site\ComplaintFormData;
use App\Http\Requests\Site\ContactFormData;
use App\Http\Requests\Site\SendCascoRequest;
use App\Http\Requests\Site\SendPersonalInsuranceRequest;
use App\Http\Requests\Site\VacancyData;
use App\Mail\CaseHappenedForm;
use App\Mail\CaseHappenedNoReply;
use App\Mail\ComplaintForm;
use App\Mail\ComplaintFormNoReply;
use App\Mail\ContactForm;
use App\Mail\ContactNoReply;
use App\Mail\SendCV;
use App\Mail\VacancyNoReply;
use App\Models\Article;
use App\Models\Block;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintStatus;
use App\Models\Doctor;
use App\Models\InsuranceType;
use App\Models\Product;
use App\Models\StaticPage;
use App\Models\Vacancy;
use App\Repository\ArticleRepositoryInterface;
use App\Repository\BlockRepositoryInterface;
use App\Repository\BranchRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ContactRepositoryInterface;
use App\Repository\DepartmentRepositoryInterface;
use App\Repository\FaqRepositoryInterface;
use App\Repository\ManagementRepositoryInterface;
use App\Repository\NavigationRepositoryInterface;
use App\Repository\PartnerRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\ReportYearRepositoryInterface;
use App\Repository\SliderRepositoryInterface;
use App\Repository\StaticPageRepositoryInterface;
use App\Repository\VacancyRepositoryInterface;
use App\Services\InsureApiService;
use App\Settings\GeneralSettings;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Throwable;

class PageController extends SiteController
{

    public function __construct(
        private BlockRepositoryInterface $blockRepository,
        private SliderRepositoryInterface $sliderRepository,
        private ReportYearRepositoryInterface $reportYearRepository,
        private BranchRepositoryInterface $branchRepository,
        private ContactRepositoryInterface $contactRepository,
        private DepartmentRepositoryInterface $departmentRepository,
        private FaqRepositoryInterface $faqRepository,
        private VacancyRepositoryInterface $vacancyRepository,
        private NavigationRepositoryInterface $navigationRepository,
        private PartnerRepositoryInterface $partnerRepository,
        private ProductRepositoryInterface $productRepository,
        private ArticleRepositoryInterface $articleRepository,
        private StaticPageRepositoryInterface $pageRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private ManagementRepositoryInterface $managementRepository,
    ) {
    }

    public function index(?string $locale = null): View
    {
        if ($locale) {
            app()->setLocale($locale);
        }

        $slides = $this->sliderRepository->getSlides('main_slider');
        $blocks = $this->blockRepository->getPageBlocks('main_page');

        return $this->render('site.index', compact('slides', 'blocks'));
    }

    public function redirectNoLocale()
    {
        return redirect()->route('index');
    }

    public function article(Category $category, Article $article)
    {
        if (!$article->active) {
            abort(404);
        }

        return $this->render('site.article', compact('article', 'category'));
    }

    public function category(Request $request, Category $category)
    {
        if (!$category->active) {
            abort(404);
        }

        return match ($category->taxonomy) {
            Category::BLOG, Category::SPECIAL_OFFERS => $this->blog($category, $request),
            Category::MANAGEMENT                     => $this->management($category),
            Category::REPORTS                        => $this->reports($category),
            Category::BRANCHES                       => $this->branches($category),
            Category::PRODUCTS                       => $this->products($category),
            Category::VACANCIES                      => $this->vacancies($category),
            Category::FAQ                            => $this->faqs($category),
            Category::DOCTORS                        => $this->doctors($category),
            Category::PARTNERS                        => $this->partners($category),
            default                                  => abort(404),
        };
    }

    public function blog(Category $category, Request $request)
    {
        $articles = $category->articles()->where('active', true);
        $hasArchive = false;
        $archiveShowed = $request->archive;
        if ($category->taxonomy === Category::BLOG) {
            $articles = $articles->orderByDesc('date')->paginate();
        } else {
            $articles =
                $articles->when($request->archive, fn(Builder $query) => $query->where('archive', true), fn(Builder $query) => $query->where('archive', false))->orderBy('_lft')
                    ->get();
            $hasArchive = $category->articles()->where('archive', true)->where('active', true)->count() > 0;
        }

        return $this->render('site.blog', compact('articles', 'category', 'hasArchive', 'archiveShowed'));
    }

    public function management(Category $category)
    {
        $managementRepository = app(ManagementRepositoryInterface::class);
        $managers = $managementRepository->allActiveNested();

        return $this->render('site.management', compact('managers', 'category'));
    }

    public function reports(Category $category)
    {
        $years = $this->reportYearRepository->allActiveOrderedBy(['year', 'desc']);

        return $this->render('site.reports', compact('years', 'category'));
    }

    public function branches(Category $category)
    {
        $branches = $this->branchRepository->allActiveNested();

        return $this->render('site.branches', compact('branches', 'category'));
    }

    public function products(Category $category)
    {
        return $this->render('site.products', compact('category'));
    }

    public function vacancies(Category $category)
    {
        $vacancies = $this->vacancyRepository->getModel()->where('active', true)->orderByDesc('date')->get();

        return $this->render('site.vacancies', compact('vacancies', 'category'));
    }

    public function faqs(Category $category)
    {
        $faqs = $this->faqRepository->allActiveNested();

        return $this->render('site.faqs', compact('faqs', 'category'));
    }

    public function doctors(Category $category)
    {
        $specialities = Cache::get('insureapi_doctors');
        $appLinkAndListBlocks = $this->blockRepository->getModel()->whereIn('type', [Block::SIDE_APP_BANNER, Block::SIDE_ICON_LINKS])->get();
        $appBlock = $appLinkAndListBlocks->where('type', Block::SIDE_APP_BANNER)->first();
        $appLinks = $appLinkAndListBlocks->where('type', Block::SIDE_ICON_LINKS)->first();

        return $this->render('site.specialities', compact('specialities', 'category', 'appBlock', 'appLinks'));
    }

    public function speciality(Category $category, int $id, InsureApiService $insureApiService)
    {
        $specialities = Cache::get('insureapi_doctors');
        $speciality = collect($specialities['specialities'])->where('id', $id)->first();
        if (!$speciality) {
            abort(404);
        }

        $doctors = Doctor::where('speciality_id', $id)->get();
        if ($doctors->isEmpty()) {
            $insureApiService->getDoctors($id, $speciality['name'] ?? '');
            $doctors = Doctor::where('speciality_id', $id)->get();
        }
        $appLinkAndListBlocks = $this->blockRepository->getModel()->whereIn('type', [Block::SIDE_APP_BANNER, Block::SIDE_ICON_LINKS])->get();
        $appBlock = $appLinkAndListBlocks->where('type', Block::SIDE_APP_BANNER)->first();
        $appLinks = $appLinkAndListBlocks->where('type', Block::SIDE_ICON_LINKS)->first();

        return $this->render('site.speciality', compact('speciality', 'category', 'doctors', 'appBlock', 'appLinks'));
    }

    public function doctor(Category $category, int $doctorId, InsureApiService $insureApiService)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $career = $insureApiService->getDoctorCareer($doctor->external_id);
        //if (!$career) {
        //    abort(404);
        //}
        $appLinkAndListBlocks = $this->blockRepository->getModel()->whereIn('type', [Block::SIDE_APP_BANNER, Block::SIDE_ICON_LINKS])->get();
        $appBlock = $appLinkAndListBlocks->where('type', Block::SIDE_APP_BANNER)->first();
        $appLinks = $appLinkAndListBlocks->where('type', Block::SIDE_ICON_LINKS)->first();

        return $this->render('site.doctor', compact('doctor', 'category', 'career', 'appBlock', 'appLinks'));
    }
    
    public function product(Category $category, Product $product)
    {
        if (!$product->active) {
            abort(404);
        }

        return $this->render('site.product', compact('product', 'category'));
    }

    public function vacancy(Category $category, Vacancy $vacancy)
    {
        return $this->render('site.vacancy', compact('vacancy', 'category'));
    }

    public function sendVacancy(VacancyData $request, GeneralSettings $settings)
    {
        $data = $request->validated();
        $file = $request->file('cv');
        $maxSize = 4096;
        if ($file->getSize() > $maxSize * 1024) {
            return \response()->json(['error' => 'File size must be less than ' . $maxSize . ' KB.']);
        }
        $allowedTypes = ['doc', 'docx', 'pdf'];
        $fileType = $file->getClientOriginalExtension();
        if (!in_array($fileType, $allowedTypes)) {
            return \response()->json(['error' => 'File type must be ' . implode(', ', $allowedTypes)]);
        }
        unset($data['cv']);
        $vacancy = Vacancy::findOrFail($data['vacancy_id']);

        try {
            Mail::to($settings->getFilteredEmails($settings->vacancyFormReceivers))->send(new SendCV($data, $file, $vacancy));
            //Mail::to(filter_var($data['email'], FILTER_SANITIZE_EMAIL))->send(new VacancyNoReply($data));
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage(), ['exception' => $throwable]);
        }


        return \response()->json(['success' => true]);
    }

    public function staticPage(StaticPage $staticPage)
    {
        if (!$staticPage->active) {
            abort(404);
        }

        return $this->render('site.static-page', compact('staticPage'));
    }

    public function contacts()
    {
        $contacts = $this->contactRepository->find(1);
        //$departments = $this->departmentRepository->allActiveNested();

        return $this->render('site.contacts', compact('contacts'));
    }

    public function sendContactForm(ContactFormData $request, GeneralSettings $settings)
    {
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['secret' => '6LeMjs0oAAAAALpzfOfrjFoD3Nj3kYoRBeWwcdeu', 'response' => $request->post('g-recaptcha-response')]
        );
        if (!$response->json()['success'] ?? true) {
            abort(400);
        }

        $data = $request->validated();
        //$department = $this->departmentRepository->find($data['department_id']);
        //$data['department'] = $department->title ?? 'empty';


        try {
            Mail::to($settings->getFilteredEmails($settings->contactsFormReceivers))->send(new ContactForm($data));
            //Mail::to(filter_var($data['email'], FILTER_SANITIZE_EMAIL))->send(new ContactNoReply($data));
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage(), ['exception' => $throwable]);
        }
    }

    public function submitProductForm(Product $product, Request $request)
    {
        try {
            $product->getForm()->handle($request);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage(), ['exception' => $throwable]);
        }

        return response()->json(['message' => 'success']);
    }

    public function cascoCalculate(CalculateCascoRequest $request, InsureApiService $insureApiService)
    {
        $executed = RateLimiter::attempt(
            'send-message:' . $request->ip(), 60, function () use ($request, $insureApiService) {
            return response()->json($insureApiService->calculateCasco($request->validated()) ?? ['error' => 'unexpected error']);
        }
        );

        return $executed ?: response()->json(['error' => 'too many attempts'], 429);
    }

    public function cascoSend(SendCascoRequest $request, InsureApiService $insureApiService)
    {
        $executed = RateLimiter::attempt(
            'send-message:' . $request->ip(), 60, function () use ($request, $insureApiService) {
            return response()->json($insureApiService->sendCasco($request->validated()) ?? ['error' => 'unexpected error']);
        }
        );

        return $executed ?: response()->json(['error' => 'too many attempts'], 429);
    }

    public function personalInsuranceCalculate(CalculatePersonalInsuranceRequest $request, InsureApiService $insureApiService)
    {
        $executed = RateLimiter::attempt(
            'send-personal:' . $request->ip(), 60, function () use ($request, $insureApiService) {
            return response()->json($insureApiService->calculatePersonalInsurance($request->validated()) ?? ['error' => 'unexpected error']);
        }
        );

        return $executed ?: response()->json(['error' => 'too many attempts'], 429);
    }

    public function personalInsuranceSend(SendPersonalInsuranceRequest $request, InsureApiService $insureApiService)
    {
        $executed = RateLimiter::attempt(
            'send-personal:' . $request->ip(), 60, function () use ($request, $insureApiService) {
            return response()->json($insureApiService->sendPersonalInsurance($request->validated()) ?? ['error' => 'unexpected error']);
        }
        );

        return $executed ?: response()->json(['error' => 'too many attempts'], 429);
    }

    public function sitemap()
    {
        $menu = $this->navigationRepository->getNavigationMenuItems('footer_navigation');

        return $this->render('site.sitemap', compact('menu'));
    }

    public function partners()
    {
        $partners = $this->partnerRepository->allActiveNested();

        return $this->render('site.partners', compact('partners'));
    }

    public function submitComplaintForm(ComplaintFormData $request, GeneralSettings $settings)
    {
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['secret' => '6LeMjs0oAAAAALpzfOfrjFoD3Nj3kYoRBeWwcdeu', 'response' => $request->post('g-recaptcha-response')]
        );
        if (!$response->json()['success'] ?? true) {
            abort(400);
        }

        $data = $request->validated();

        try {
            Mail::to($settings->getFilteredEmails($settings->complaintFormReceivers))->send(new ComplaintForm($data));
            //Mail::to(filter_var($data['email'], FILTER_SANITIZE_EMAIL))->send(new ComplaintFormNoReply($data));
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage(), ['exception' => $throwable]);
        }

        return response()->json(['status' => 'success']);
    }

    public function checkComplaintForm(CheckComplaintFormData $request, InsureApiService $insureApiService)
    {
        $complaint = $insureApiService->checkComplaint($request->post('complaintId'), $request->post('personalId'));

        return response()->json(['status' => 'success', 'data' => $complaint]);
    }

    public function submitCaseHappenedForm(CaseHappenedFormData $request, GeneralSettings $settings)
    {
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['secret' => '6LeMjs0oAAAAALpzfOfrjFoD3Nj3kYoRBeWwcdeu', 'response' => $request->post('g-recaptcha-response')]
        );
        if (!$response->json()['success'] ?? true) {
            abort(400);
        }

        $insuranceType = InsuranceType::findOrFail($request->post('insurance_type_id'));
        $data = $request->validated();
        $data['insurance_type'] = $insuranceType->title;

        try {
            Mail::to($settings->getFilteredEmails($insuranceType->form_recipients))->send(new CaseHappenedForm($data));
            //Mail::to(filter_var($data['email'], FILTER_SANITIZE_EMAIL))->send(new CaseHappenedNoReply($data));
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage(), ['exception' => $throwable]);
        }

        return response()->json(['status' => 'success']);
    }

    public function search(Request $request): View
    {
        $products = $this->productRepository->search($request)->sortBy('_lft');
        $other = $this->categoryRepository->search($request, 6);
        if ($other->count() < 6) {
            $articles = $this->articleRepository->search($request, 6);
            $other = $other->concat($articles);
            if ($other->count() < 6) {
                $laboratories = $this->branchRepository->search($request);
                $other = $other->concat($laboratories);
            }
            if ($other->count() < 6) {
                $vacancies = $this->vacancyRepository->search($request);
                $other = $other->concat($vacancies);
            }
            if ($other->count() < 6) {
                $staticPages = $this->pageRepository->search($request);
                $other = $other->concat($staticPages);
            }
            if ($other->count() < 6) {
                $categories = $this->managementRepository->search($request);
                $other = $other->concat($categories);
            }
            if ($other->count() < 6) {
                $categories = $this->faqRepository->search($request);
                $other = $other->concat($categories);
            }
        }
        return $this->render('site.search', compact('products', 'other'));
    }

    public function searchOther(Request $request): View
    {
        $other = $this->categoryRepository->search($request, 5);

        $articles = $this->articleRepository->search($request, 5);
        $other = $other->concat($articles);

        $laboratories = $this->branchRepository->search($request, 5);
        $other = $other->concat($laboratories);

        $vacancies = $this->vacancyRepository->search($request, 5);
        $other = $other->concat($vacancies);

        $staticPages = $this->pageRepository->search($request, 5);
        $other = $other->concat($staticPages);

        $categories = $this->managementRepository->search($request, 5);
        $other = $other->concat($categories);

        $categories = $this->faqRepository->search($request, 5);
        $other = $other->concat($categories);

        return $this->render('site.search_other', compact('other'));
    }

    public function redirectHealthInsurancePackages(Request $request)
    {
        if ($request->get('section') === 'ozel') {
            return redirect()->to('az/tibbi-sigorta-ferdi-sexslere/product/konullu-tibbi-sigorta-ozel');
        }

        if ($request->get('section') === 'aile') {
            return redirect()->to('az/tibbi-sigorta-ferdi-sexslere/product/konullu-tibbi-sigorta-aile');
        }

        if ($request->get('section') === 'ferqli') {
            return redirect()->to('az/tibbi-sigorta-ferdi-sexslere');
        }

        if ($request->get('section') === 'fors-major') {
            return redirect()->to('az/tibbi-sigorta-ferdi-sexslere/product/konullu-tibbi-sigorta-fors-major');
        }

        abort(404);
    }

    public function redirectHealthInsurancePackagesRu(Request $request)
    {
        if ($request->get('section') === 'ozel') {
            return redirect()->to('ru/tibbi-sigorta-ferdi-sexslere/product/konullu-tibbi-sigorta-ozel');
        }

        if ($request->get('section') === 'aile') {
            return redirect()->to('ru/tibbi-sigorta-ferdi-sexslere/product/konullu-tibbi-sigorta-aile');
        }

        if ($request->get('section') === 'ferqli') {
            return redirect()->to('ru/tibbi-sigorta-ferdi-sexslere/product/konullu-tibbi-sigorta-ferqli');
        }

        if ($request->get('section') === 'fors-major') {
            return redirect()->to('ru/tibbi-sigorta-ferdi-sexslere/product/konullu-tibbi-sigorta-fors-major');
        }

        abort(404);
    }

    public function redirectMedecineInsurance(Request $request)
    {
        if ($request->get('section') === 'personal') {
            return redirect()->to('az/tibbi-sigorta-ferdi-sexslere');
        }

        if ($request->get('section') === 'corporate') {
            return redirect()->to('az/tibbi-sigorta-korporativ-musterilere');
        }

        abort(404);
    }

    public function redirectMedecineInsuranceRu(Request $request)
    {
        if ($request->get('section') === 'personal') {
            return redirect()->to('ru/tibbi-sigorta-ferdi-sexslere');
        }

        if ($request->get('section') === 'corporate') {
            return redirect()->to('ru/tibbi-sigorta-korporativ-musterilere');
        }

        abort(404);
    }
    public function redirectAutoInsurance(Request $request)
    {
        if ($request->get('section') === 'personal') {
            return redirect()->to('az/avtomobil-sigortasi-ferdi-sexslere');
        }

        if ($request->get('section') === 'corporate') {
            return redirect()->to('az/avtomobil-sigortasi-korporativ-musterilere/product/korporativ-musteriler-ucun-kasko');
        }

        abort(404);
    }
    public function redirectAutoInsuranceRu(Request $request)
    {
        if ($request->get('section') === 'personal') {
            return redirect()->to('ru/avtomobil-sigortasi-ferdi-sexslere');
        }

        if ($request->get('section') === 'corporate') {
            return redirect()->to('ru/avtomobil-sigortasi-korporativ-musterilere/product/korporativ-musteriler-ucun-kasko');
        }

        abort(404);
    }

    public function redirectAboutUs(Request $request)
    {
        if ($request->get('section') === 'company') {
            return redirect()->to('az/pages/about-company');
        }
        if ($request->get('section') === 'finance') {
            return redirect()->to('az/maliyye-gosterecileri');
        }
        if ($request->get('section') === 'feedback') {
            return redirect()->to('az/customers');
        }
        if ($request->get('section') === 'leadership') {
            return redirect()->to('az/rehberlik');
        }
        if ($request->get('section') === 'faq') {
            return redirect()->to('az/faq-tez-tez-verilen-suallar');
        }
        if ($request->get('section') === 'insurance-rules') {
            return redirect()->to('az/pages/sigorta-qaydalari');
        }

        abort(404);
    }

    public function redirectAboutUsRu(Request $request)
    {
        if ($request->get('section') === 'company') {
            return redirect()->to('ru/pages/about-company');
        }
        if ($request->get('section') === 'finance') {
            return redirect()->to('ru/maliyye-gosterecileri');
        }
        if ($request->get('section') === 'feedback') {
            return redirect()->to('ru/customers');
        }
        if ($request->get('section') === 'leadership') {
            return redirect()->to('ru/rehberlik');
        }
        if ($request->get('section') === 'faq') {
            return redirect()->to('ru/faq-tez-tez-verilen-suallar');
        }
        if ($request->get('section') === 'insurance-rules') {
            return redirect()->to('ru/pages/sigorta-qaydalari');
        }

        abort(404);
    }
}
