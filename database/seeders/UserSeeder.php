<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2b$10$j9wbM3Xe5Am2TWahpOrbZeTKhmk7bZoK8X5NVbLBhmOLRC2JnVuW.', //pass: "admin"
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
