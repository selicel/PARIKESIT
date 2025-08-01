<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'opd',
            'email' => 'opd@example.com',
            'password' => bcrypt('password'),
            'role' => 'opd',
            'alamat' => 'Jl. Pahlawan Revolusi No.123',
            'nomor_telepon' => '081234567890',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'alamat' => 'Jl. Pahlawan Revolusi No.123',
            'nomor_telepon' => '081234567890',
        ]);

         User::factory()->create([
            'name' => 'Admin_2',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'alamat' => 'Jl. Pahlawan',
            'nomor_telepon' => '0828828282',
        ]);

        User::factory()->create([
            'name' => 'Walidata',
            'email' => 'walidata@example.com',
            'password' => bcrypt('password'),
            'role' => 'walidata',
            'alamat' => 'Jl. Pahlawan Revolusi No.123',
            'nomor_telepon' => '081234567890',
        ]);

        $faker = Faker::create();


        for ($i = 0; $i < 10; $i++) {
            $uniqueInt = $faker->unique()->numberBetween(100000, 999999); // angka acak unik 6 digit

            User::factory()->create([
                'name' => "OPD $faker->name",
                'email' => "opd_$i@example.com",
                'password' => bcrypt('password'),
                'role' => 'opd',
                'alamat' => 'Jl. Pahlawan Revolusi No.123',
                'nomor_telepon' => "081234$uniqueInt",
            ]);
        }


    }
}
