<?php

use Spatie\LaravelSettings\Exceptions\SettingAlreadyExists;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    /**
     * @throws SettingAlreadyExists
     */
    public function up(): void
    {
        $this->migrator->add('general.complaintFormReceivers', 'samir@mediadesign.az');
        $this->migrator->add('general.caseHappenedFormReceivers', 'samir@mediadesign.az');
        $this->migrator->add('general.contactsFormReceivers', 'samir@mediadesign.az');
        $this->migrator->add('general.vacancyFormReceivers', 'samir@mediadesign.az');
    }
}
