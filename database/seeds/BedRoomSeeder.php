<?php

use Illuminate\Database\Seeder;

class BedRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('beds')->insert([
            'bed_type' => 'King'
        ]);
        DB::table('beds')->insert([
            'bed_type' => 'Queen'
        ]);
        DB::table('beds')->insert([
            'bed_type' => 'Double'
        ]);
        DB::table('beds')->insert([
            'bed_type' => 'Single'
        ]);
    }
}
