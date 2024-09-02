<?php

namespace Database\Seeders\Contacts;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run()
    {
        Contact::create([
            'phones' => '(+994 12) 222 33 33',
            'email' => 'info@test.az',
            'address' => 'test address',
        ]);
    }
}
