<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
                ->count(2)
                ->hasContacts(10) // 10 contact per user
                ->create();

        Contact::factory()
                ->count(50)
                ->hasCallLogs(10) // 10 contact per user
                ->create();

    }
}
