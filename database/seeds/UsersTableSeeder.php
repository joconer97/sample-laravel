<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'firstname' => 'Arnel',
            'middleinitial' => 'O',
            'lastname' => 'Payongayong',
            'address' => 'Secret',
            'city' => 'Naga City',
            'landmark' => 'Secret',
            'zip' => '4400',
            'profile_pic' => '',
            'position' => 'Superadmin',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('admin'),
        ]);
    }
}
