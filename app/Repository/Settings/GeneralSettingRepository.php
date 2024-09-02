<?php

namespace App\Repository\Settings;

use App\Repository\FileRepositoryInterface;
use App\Repository\GeneralSettingRepositoryInterface;
use App\Settings\GeneralSettings;
use Spatie\LaravelSettings\Settings;
use Storage;

class GeneralSettingRepository extends SettingRepository implements GeneralSettingRepositoryInterface
{
    public function __construct(GeneralSettings $settings)
    {
        parent::__construct($settings);
    }

    public function update(array $data): Settings
    {
        $this->settings->complaintFormReceivers = $data['complaintFormReceivers'];
        $this->settings->contactsFormReceivers = $data['contactsFormReceivers'];
        $this->settings->vacancyFormReceivers = $data['vacancyFormReceivers'];

        return $this->settings->save();
    }

    public function get(): Settings
    {
        return $this->settings;
    }
}
