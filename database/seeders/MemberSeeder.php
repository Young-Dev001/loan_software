<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        // Generate 45 members with fake data
        for ($i = 1; $i <= 15; $i++) {
            DB::table('members')->insert([
                'sub_group_id' => $faker->numberBetween(1, 3),
                'registration_fee' => 500,
                'registration_date' => $faker->date(),
                'id_number' => $faker->unique()->numerify('#######'),
                'name' => $faker->name,
                'postal_address' => $faker->address,
                'residence' => $faker->city,
                'town' => $faker->city,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), 
                'photo' => null,
                'phone' => '+2547' . substr($faker->e164PhoneNumber, 4), // Generate +254 phone numbers
                'nationality' => $faker->randomElement(['Kenyan', 'Foreign']),
                'status' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
