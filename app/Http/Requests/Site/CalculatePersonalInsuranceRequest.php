<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CalculatePersonalInsuranceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'birthDay' => 'required|date',
            'haveExaminedInLast2Years' => 'required|boolean',
            'areHospitalized' => 'required|boolean',
            'haveTreatmentOrMedication' => 'required|boolean',
            'haveDiseasesOfTheEsophagusAndGastrointestinalTract' => 'required|boolean',
            'haveAsthmaAllergiesLungDiseases' => 'required|boolean',
            'haveDiseasesOfTheKidneysOrUrinarySystem' => 'required|boolean',
            'haveCongenitalAndInheritedDiseases' => 'required|boolean',
            'haveHeadachesDizzinessAndMigraines' => 'required|boolean',
            'haveBloodPressure' => 'required|boolean',
            'haveRheumatism' => 'required|boolean',
            'havevaricoseVeinsAndOtherVascularDiseases' => 'required|boolean',
            'haveRhythmConductionDisturbancesAndHeartDisease' => 'required|boolean',
            'haveMentalIllnessNervousDisorderEpilepsy' => 'required|boolean',
            'haveTraumasInjuriesDefects' => 'required|boolean',
            'haveProblemsWithLumbarRegionAndSpine' => 'required|boolean',
            'haveDiseasesOfTheLiverSpleenPancreas' => 'required|boolean',
            'haveBloodDiseases' => 'required|boolean',
            'haveDiabetes' => 'required|boolean',
            'haveOtherEndocrineDiseases' => 'required|boolean',
            'havebenignOrMalignantTumors' => 'required|boolean',
            'haveAnyHealthProblemsOtherThanAbove' => 'required|boolean',
            'haveInsuredWithAnotherInsuranceCompany' => 'required|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
