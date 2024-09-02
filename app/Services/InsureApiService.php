<?php

namespace App\Services;

use App\Models\Doctor;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleXMLElement;
use Throwable;

class InsureApiService
{
    public const API_URL = 'https://insure.a-group.az';
    public const GET_BRANDS_LIST = '/insureazSvc/AQrupCascoCalcSvc.asmx/GetBrandsList';
    public const GET_PRODUCTION_YEARS = '/insureazSvc/AQrupCascoCalcSvc.asmx/GetProductionYears';
    public const GET_REPAIR_SHOPS = '/insureazSvc/AQrupCascoCalcSvc.asmx/GetRepairShops';
    public const GET_FRANCHISES = '/insureazSvc/AQrupCascoCalcSvc.asmx/GetFranchises';
    public const GET_DRIVERS = '/insureazSvc/AQrupCascoCalcSvc.asmx/GetDrvers';
    public const GET_INSTALLMENTS = '/insureazSvc/AQrupCascoCalcSvc.asmx/GetInstallments';
    public const GET_BONUSES = '/insureazSvc/AQrupCascoCalcSvc.asmx/GetBonuses';
    public const CALCULATE_CASCO = '/insureazSvc/AQrupCascoCalcSvc.asmx/Calculate';
    public const CASCO_ORDER = '/insureazSvc/AQroupMobileIntegrationSvc.asmx/CreateCascoPolicyOrder';
    public const CALCULATE_MEDICAL_INSURANCE = '/insureazSvc/AQroupMobileIntegrationSvc.asmx/CalculateMedicalInsurancePrice';
    public const ORDER_MEDICAL_INSURANCE = '/insureazSvc/AQroupMobileIntegrationSvc.asmx/CreateMedicalPolicyOrder';
    public const GET_SPECIALITIES = '/insureazSvc/AQroupMobileIntegrationSvc.asmx/GetSpecialities';
    public const GET_DOCTORS_BY_SPECIALITIES = '/insureazSvc/AQroupMobileIntegrationSvc.asmx/GetDoctorsBySpecialtiy';
    public const GET_DOCTOR_CAREER = '/insureazSvc/AQroupMobileIntegrationSvc.asmx/GetDoctorCareer';
    public const CHECK_COMPLAINT_STATUS = '/InsureAzSvc/GeneralComplaintSvc.asmx/GetComplaintStatus';

    private string $userName;
    private string $password;

    private Client $client;

    public function __construct()
    {
        $this->userName = config('insureapi.username');
        $this->password = config('insureapi.password');
        $this->client = new Client(['verify' => false]);
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getBrandList(): bool
    {
        $request = $this->client->get(self::API_URL . self::GET_BRANDS_LIST, ['query' => ['username' => $this->userName, 'password' => $this->password]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting brands list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $cache = Cache::get('insureapi');
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            foreach ($data->BrandLst as $brand) {
                $cache['brands'][] = [
                    'id' => (int)$brand->ID,
                    'name' => (string)$brand->Name,
                ];
            }

            Cache::forever('insureapi', $cache);

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting brands list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getProductionYears(): bool
    {
        $request = $this->client->get(self::API_URL . self::GET_PRODUCTION_YEARS, ['query' => ['username' => $this->userName, 'password' => $this->password]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting production years from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $cache = Cache::get('insureapi');
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            foreach ($data->ProdYearLst as $year) {
                $cache['years'][] = [
                    'id' => (int)$year->ID,
                    'name' => (string)$year->Name,
                ];
            }

            Cache::forever('insureapi', $cache);

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting years list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getRepairShops(): bool
    {
        $request = $this->client->get(self::API_URL . self::GET_REPAIR_SHOPS, ['query' => ['username' => $this->userName, 'password' => $this->password]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting repair shops from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $cache = Cache::get('insureapi');
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            foreach ($data->RepShopLst as $shop) {
                $cache['shops'][] = [
                    'id' => (int)$shop->ID,
                    'name' => (string)$shop->Name,
                ];
            }

            Cache::forever('insureapi', $cache);

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting shop list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getFranchises(): bool
    {
        $request = $this->client->get(self::API_URL . self::GET_FRANCHISES, ['query' => ['username' => $this->userName, 'password' => $this->password]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting franchises list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $cache = Cache::get('insureapi');
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            foreach ($data->FranLst as $franchise) {
                $cache['franchises'][] = [
                    'id' => (int)$franchise->ID,
                    'name' => (string)$franchise->Name,
                ];
            }

            Cache::forever('insureapi', $cache);

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting shop list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getDrivers(): bool
    {
        $request = $this->client->get(self::API_URL . self::GET_DRIVERS, ['query' => ['username' => $this->userName, 'password' => $this->password]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting driver list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $cache = Cache::get('insureapi');
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            foreach ($data->DriversLst as $driver) {
                $cache['drivers'][] = [
                    'id' => (int)$driver->ID,
                    'name' => (string)$driver->Name,
                ];
            }

            Cache::forever('insureapi', $cache);

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting drivers list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getInstallments(): bool
    {
        $request = $this->client->get(self::API_URL . self::GET_INSTALLMENTS, ['query' => ['username' => $this->userName, 'password' => $this->password]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting installments list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $cache = Cache::get('insureapi');
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            foreach ($data->InstallLst as $installment) {
                $cache['installments'][] = [
                    'id' => (int)$installment->ID,
                    'name' => (string)$installment->Name,
                ];
            }

            Cache::forever('insureapi', $cache);

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting drivers list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getBonuses(): bool
    {
        $request = $this->client->get(self::API_URL . self::GET_BONUSES, ['query' => ['username' => $this->userName, 'password' => $this->password]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting bonuses list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $cache = Cache::get('insureapi');
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            foreach ($data->BonLst as $bonus) {
                $cache['bonuses'][] = [
                    'id' => (int)$bonus->ID,
                    'name' => (string)$bonus->Name,
                ];
            }

            Cache::forever('insureapi', $cache);

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting bonuses list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function calculateCasco(array $data): ?array
    {
        $data['username'] = $this->userName;
        $data['password'] = $this->password;
        try {
            $data['bonus'] = (string)collect(Cache::get('insureapi')['bonuses'])->first()['id'];
            $data['installment'] = (string)collect(Cache::get('insureapi')['installments'])->first()['id'];
        } catch (Throwable $e) {
            $data['bonus'] = 1;
            $data['installment'] = 1;
        }


        try {
            $request = $this->client->post(self::API_URL . self::CALCULATE_CASCO, ['form_params' => $data]);
            if ($request->getStatusCode() !== 200) {
                Log::channel('insureapi')->error(
                    'Error while calculating casco from insureapi',
                    ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
                );
            }

            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));

            return [
                'error' => (string)$data->CalcResult->HasException ? __('site.casco_' . Str::slug((string)$data->CalcResult->ExceptionMsg)) : null,
                'price' => (string)$data->CalcResult->BruttoPremium,
            ];
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while calculating casco insureapi',
                ['exception' => $e]
            );

            return null;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function calculatePersonalInsurance(array $data): ?array
    {
        $data['username'] = $this->userName;
        $data['password'] = $this->password;
        $data['programId'] = 1;

        try {
            $questions = ['haveExaminedInLast2Years', 'areHospitalized', 'haveTreatmentOrMedication', 'haveDiseasesOfTheEsophagusAndGastrointestinalTract', 'haveAsthmaAllergiesLungDiseases',
                'haveDiseasesOfTheKidneysOrUrinarySystem', 'haveCongenitalAndInheritedDiseases', 'haveHeadachesDizzinessAndMigraines', 'haveBloodPressure', 'haveRheumatism',
                'havevaricoseVeinsAndOtherVascularDiseases', 'haveRhythmConductionDisturbancesAndHeartDisease', 'haveMentalIllnessNervousDisorderEpilepsy', 'haveTraumasInjuriesDefects',
                'haveProblemsWithLumbarRegionAndSpine', 'haveDiseasesOfTheLiverSpleenPancreas', 'haveBloodDiseases', 'haveDiabetes', 'haveOtherEndocrineDiseases',
                'havebenignOrMalignantTumors', 'haveAnyHealthProblemsOtherThanAbove', 'haveInsuredWithAnotherInsuranceCompany'];
            foreach ($questions as $question) {
                $data[$question] = $data[$question] === '1' ? 'true' : 'false';
            }

            $request = $this->client->post(self::API_URL . self::CALCULATE_MEDICAL_INSURANCE, ['form_params' => $data]);
            if ($request->getStatusCode() !== 200) {
                Log::channel('insureapi')->error(
                    'Error while calculating ozal insureapi',
                    ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
                );
            }

            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));

            if (isset($data->ERROR) && $data->ERROR) {
                return [
                    'error' => __('ozal.' . Str::slug($data->ERROR->MESSAGE))
                ];
            }

            if (isset($data->INSURANCE_PRICE) && $data->INSURANCE_PRICE) {
                return [
                    'price' => (float)$data->INSURANCE_PRICE->TOTAL_INSURANCE_PRICE,
                    'error' => null
                ];
            }

            return [
                'error' => 'unexpected_error',
            ];
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while calculating ozal insureapi',
                ['exception' => $e]
            );

            return null;
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendPersonalInsurance(array $data): ?array
    {
        $data['username'] = $this->userName;
        $data['password'] = $this->password;
        $data['programId'] = 1;

        try {
            $questions = ['haveExaminedInLast2Years', 'areHospitalized', 'haveTreatmentOrMedication', 'haveDiseasesOfTheEsophagusAndGastrointestinalTract', 'haveAsthmaAllergiesLungDiseases',
                'haveDiseasesOfTheKidneysOrUrinarySystem', 'haveCongenitalAndInheritedDiseases', 'haveHeadachesDizzinessAndMigraines', 'haveBloodPressure', 'haveRheumatism',
                'havevaricoseVeinsAndOtherVascularDiseases', 'haveRhythmConductionDisturbancesAndHeartDisease', 'haveMentalIllnessNervousDisorderEpilepsy', 'haveTraumasInjuriesDefects',
                'haveProblemsWithLumbarRegionAndSpine', 'haveDiseasesOfTheLiverSpleenPancreas', 'haveBloodDiseases', 'haveDiabetes', 'haveOtherEndocrineDiseases',
                'havebenignOrMalignantTumors', 'haveAnyHealthProblemsOtherThanAbove', 'haveInsuredWithAnotherInsuranceCompany'];
            foreach ($questions as $question) {
                $data[$question] = $data[$question] === '1' ? 'true' : 'false';
            }

            $request = $this->client->post(self::API_URL . self::ORDER_MEDICAL_INSURANCE, ['form_params' => $data]);
            if ($request->getStatusCode() !== 200) {
                Log::channel('insureapi')->error(
                    'Error while calculating ozal insureapi',
                    ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
                );
            }

            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));

            if (isset($data->ERROR) && $data->ERROR) {
                return [
                    'error' => __('ozal.' . Str::slug($data->ERROR->MESSAGE))
                ];
            }

            if (isset($data->RESULT) && $data->RESULT && (bool)$data->RESULT->SUCESS === true) {
                return [
                    'error' => null,
                    'success' => true
                ];
            }

            return [
                'error' => 'unexpected_error',
            ];
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while calculating ozal insureapi',
                ['exception' => $e]
            );

            return null;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function sendCasco(array $data)
    {
        $calculation = $this->calculateCasco($data);
        if ($calculation['error']) {
            return $calculation;
        }

        $data['username'] = $this->userName;
        $data['password'] = $this->password;

        try {
            $data['bonus'] = (string)collect(Cache::get('insureapi')['bonuses'])->first()['id'];
            $data['installment'] = (string)collect(Cache::get('insureapi')['installments'])->first()['id'];
        } catch (Throwable $e) {
            $data['bonus'] = 1;
            $data['installment'] = 1;
        }

        try {
            /** @var UploadedFile $idCardFront */
            $idCardFront = $data['idCardFront'];
            $data['idCard1Content'] = base64_encode($idCardFront->getContent());
            $data['idCard1FileExtension'] = $idCardFront->getClientOriginalExtension();
            unset($data['idCardFront']);
            /** @var UploadedFile $idCardBack */
            $idCardBack = $data['idCardBack'];
            $data['idCard2Content'] = base64_encode($idCardBack->getContent());
            $data['idCard2FileExtension'] = $idCardBack->getClientOriginalExtension();
            unset($data['idCardBack']);

            /** @var UploadedFile $texPassportFront */
            $texPassportFront = $data['texPassportFront'];
            $data['texPasport1Content'] = base64_encode($texPassportFront->getContent());
            $data['texPasport1FileExtension'] = $texPassportFront->getClientOriginalExtension();
            unset($data['texPassportFront']);
            /** @var UploadedFile $texPassportBack */
            $texPassportBack = $data['texPassportBack'];
            $data['texPasport2Content'] = base64_encode($texPassportBack->getContent());
            $data['texPasport2FileExtension'] = $texPassportBack->getClientOriginalExtension();
            unset($data['texPassportBack']);

            /** @var UploadedFile $driveLicenseFront */
            $driveLicenseFront = $data['driveLicenseFront'];
            $data['driveLicense1Content'] = base64_encode($driveLicenseFront->getContent());
            $data['driveLicense1FileExtension'] = $driveLicenseFront->getClientOriginalExtension();
            unset($data['driveLicenseFront']);
            /** @var UploadedFile $driveLicenseBack */
            $driveLicenseBack = $data['driveLicenseBack'];
            $data['driveLicense2Content'] = base64_encode($driveLicenseBack->getContent());
            $data['driveLicense2FileExtension'] = $driveLicenseBack->getClientOriginalExtension();
            unset($data['driveLicenseBack']);

            /** @var UploadedFile $etibarnameFront */
            $etibarnameFront = $data['etibarnameFront'];
            $data['etibarname1Content'] = base64_encode($etibarnameFront->getContent());
            $data['etibarname1FileExtension'] = $etibarnameFront->getClientOriginalExtension();
            unset($data['etibarnameFront']);
            /** @var UploadedFile $etibarnameBack */
            $etibarnameBack = $data['etibarnameBack'];
            $data['etibarname2Content'] = base64_encode($etibarnameBack->getContent());
            $data['etibarname2FileExtension'] = $etibarnameBack->getClientOriginalExtension();
            unset($data['etibarnameBack']);

            $request = $this->client->post(self::API_URL . self::CASCO_ORDER, ['form_params' => $data]);
            if ($request->getStatusCode() !== 200) {
                Log::channel('insureapi')->error(
                    'Error while create order casco from insureapi',
                    ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
                );
            }

            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            if (isset($data->ERROR) && $data->ERROR) {
                return [
                    'error' => (string)$data->ERROR->MESSAGE,
                ];
            }

            if (isset($data->RESULT) && $data->RESULT && (bool)$data->RESULT->SUCESS === true) {
                return [
                    'error' => null,
                    'success' => true
                ];
            }

            return [
                'error' => 'unexpected_error',
            ];
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while create order casco insureapi',
                ['exception' => $e]
            );

            return null;
        }
    }

    public function getSpecialities()
    {
        $request = $this->client->get(self::API_URL . self::GET_SPECIALITIES, ['query' => ['username' => $this->userName, 'password' => $this->password]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting specialities list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $cache = Cache::get('insureapi_doctors');
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            foreach ($data->SPECIALITIES as $speciality) {
                $cache['specialities'][(int)$speciality->SPECIALITY_ID] = [
                    'id' => (int)$speciality->SPECIALITY_ID,
                    'name' => (string)$speciality->SPECIALITY_NAME,
                ];
            }

            Cache::forever('insureapi_doctors', $cache);

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting specialities list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    public function getDoctors(int $speciality, $specialityTitle)
    {
        $request = $this->client->get(self::API_URL . self::GET_DOCTORS_BY_SPECIALITIES, ['query' => ['username' => $this->userName, 'password' => $this->password, 'specialityId' => $speciality]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting doctors list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            $currentDoctors = [];
            foreach ($data->DOCTORS as $doctor) {
                Doctor::query()->updateOrCreate([
                    'external_id' => (int)$doctor->CUSTOMER_ID,
                    'speciality_id' => $speciality,
                ],[
                    'speciality_title' => $specialityTitle,
                    'name' => (string)$doctor->NAME,
                    'workplace' => (string)$doctor->WORKPLACE_NAME,
                    'image64' => (string)$doctor->FILE_CONTENT,
                    'rating' => (float)$doctor->CUSTOMER_POINT,
                ]);

                $currentDoctors[] = (int)$doctor->CUSTOMER_ID;
            }

            Doctor::query()->where('speciality_id', $speciality)->whereNotIn('external_id', $currentDoctors)->delete();

            return true;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting doctors list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }
    public function updateDoctors()
    {
        $specialities = Cache::get('insureapi_doctors');
        foreach ($specialities['specialities'] as $speciality) {
            $this->getDoctors($speciality['id'], $speciality['name']);
        }
    }


    public function getDoctorCareer(int $doctorId)
    {
        $request = $this->client->get(self::API_URL . self::GET_DOCTOR_CAREER, ['query' => ['username' => $this->userName, 'password' => $this->password, 'doctorId' => $doctorId]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting doctors list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));
            $careers = [];
            foreach ($data->DOCTOR_CAREER as $career) {
                $careers[] = [
                    'id' => (int)$career->CAREER_ID,
                    'doctor_id' => (string)$career->CUSTOMER_ID,
                    'type' => (int)$career->CAREER_TYPE_ID,
                    'start_year' => (int)$career->START_YEAR,
                    'end_year' => (int)$career->END_YEAR,
                    'speciality' => (string)$career->SPECIALITY_AZ,
                    'enterprise' => (string)$career->ENTERPRISE_AZ,
                    'place' => (string)$career->PLACE_AZ,
                ];
            }

            return $careers;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting doctors list from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }

    public function checkComplaint(string $complaintId, string $personalId)
    {
        $request = $this->client->get(self::API_URL . self::CHECK_COMPLAINT_STATUS, ['query' => ['username' => $this->userName, 'password' => $this->password, 'complaintNumber' => $complaintId, 'pinCode' => $personalId]]);
        if ($request->getStatusCode() !== 200) {
            Log::channel('insureapi')->error(
                'Error while getting complaint status from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents()]
            );
        }

        try {
            $response = $request->getBody()->getContents();
            $data = (new SimpleXMLElement(((array)(new SimpleXMLElement($response))[0])[0]));

            if ((int)$data->ComplaintStatus->HasException[0] === 1) {
                return ['error' => __('site.' . Str::slug((string)$data->ComplaintStatus->Exception))];
            }

            $dataResponse = '';
            foreach ($data->ComplaintStatus as $status) {
                $dataResponse .= "<p>" . __('site.complaint_status') . ": {$status->Text} <br> " . __('site.complaint_date') . ": {$status->Date}";
                if ((string)$status->File) {
                    $fileLink = (string)$status->File;
                    if (Str::startsWith($fileLink, 'http://')) {
                        $fileLink = Str::replaceFirst('http://', 'https://', $fileLink);
                    }
                    $dataResponse .= "<br>" . __('site.complaint_file') . ": <a href='" . $fileLink . "' target='_blank'>" . __('site.download') . "</a>";
                }
                $dataResponse .= "</p>";
            }

            return $dataResponse;
        } catch (Throwable $e) {
            Log::channel('insureapi')->error(
                'Error while getting complaint status from insureapi',
                ['status_code' => $request->getStatusCode(), 'body' => $request->getBody()->getContents(), 'exception' => $e]
            );

            return false;
        }
    }
}
