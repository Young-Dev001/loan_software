<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;
class SubGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();


        // Seed three groups with fake data
        for ($i = 1; $i <= 15; $i++) {
            $groupName = 'Sub-Group ' . chr(64 + $i); // A: 65, B: 66, C: 67

            DB::table('sub_groups')->insert([
                'name' => $groupName,
                'group_id' => $faker->numberBetween(1, 3),
                'description' => $faker->sentence,
                'status' => '1', // You can change the status if needed
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
