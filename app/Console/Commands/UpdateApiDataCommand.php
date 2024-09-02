<?php

namespace App\Console\Commands;

use App\Services\InsureApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateApiDataCommand extends Command
{
    protected $signature = 'update:api-data';

    protected $description = 'Command description';

    public function handle(): void
    {
        $insureApiService = app(InsureApiService::class);
        try {
            Cache::forget('insureapi');
            Cache::forget('insureapi_doctors');
            $insureApiService->getBrandList();
            $insureApiService->getProductionYears();
            $insureApiService->getRepairShops();
            $insureApiService->getFranchises();
            $insureApiService->getDrivers();
            $insureApiService->getInstallments();
            $insureApiService->getBonuses();
            $insureApiService->getSpecialities();
            $insureApiService->updateDoctors();
        } catch (Throwable $throwable) {
            Log::critical($throwable->getMessage());
        }

        Log::info('Api data updated successfully');
    }
}
