<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        // Generate 10 suppliers with fake data
        for ($i = 1; $i <= 10; $i++) {
            DB::table('suppliers')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => '+2547' . substr($faker->e164PhoneNumber, 4), // Generate +254 phone numbers
                'address' => $faker->address,
                'status' => '1', // You can change the status if needed
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
}