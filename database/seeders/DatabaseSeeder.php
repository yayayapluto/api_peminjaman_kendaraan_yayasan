<?php

namespace Database\Seeders;

use App\Models\Record;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Log;
use Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Log::info("Start truncate");
        User::truncate();
        Vehicle::truncate();
        Record::truncate();
        Notification::truncate();

        User::factory(10)->create();
        Vehicle::factory(3)->create();
        Record::factory(5)->create();
        Notification::factory(5)->create();

        Schema::enableForeignKeyConstraints();
    }
}
