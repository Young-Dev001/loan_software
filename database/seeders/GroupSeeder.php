<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = FakerFactory::create();

        // Banks to seed
        $banks = ['KCB', 'Equity Bank', 'Ecobank Kenya', 'NCBA Bank Kenya', 'Cooperative Bank of Kenya'];

        // Seed three groups with fake data
        for ($i = 1; $i <= 3; $i++) {
            $groupName = 'Group ' . chr(64 + $i); // A: 65, B: 66, C: 67

            DB::table('groups')->insert([
                'name' => $groupName,
                'description' => $faker->sentence,
                'bank_name' => $faker->randomElement($banks),
                'account_number' => $faker->bankAccountNumber,
                'status' => '1', // You can change the status if needed
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
