<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Product::factory(20)->create();
        $this->call([

            ChairmanSeeder::class,
            TreasurerSeeder::class,
            SecretarySeeder::class,
            OfficerSeeder::class,
            AdminSeeder::class,
            MemberSeeder::class,
            SupplierSeeder::class,
            GroupSeeder::class,
            SubGroupSeeder::class,
            SettingsSeeder::class,
            // Add other seeders if you have more
        ]);
    }
}
