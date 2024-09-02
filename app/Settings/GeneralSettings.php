<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $complaintFormReceivers;
    public string $caseHappenedFormReceivers;
    public string $contactsFormReceivers;
    public string $vacancyFormReceivers;

    public function getFilteredEmails(string $emails): array
    {
        return array_filter(array_map('trim', explode(PHP_EOL, $emails)));
    }

    public static function group(): string
    {
        return 'general';
    }
}
