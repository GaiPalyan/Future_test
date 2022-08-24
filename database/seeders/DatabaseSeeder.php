<?php

declare(strict_types=1);

namespace Database\Seeders;


use App\Models\Company;
use App\Models\Contact;
use App\Models\Person;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory()->count(5)->create();
    }
}
