<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SizesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
            'size' => 'U',
        ]);

        DB::table('sizes')->insert([
            'size' => 'PP',
        ]);

        DB::table('sizes')->insert([
            'size' => 'P',
        ]);

        DB::table('sizes')->insert([
            'size' => 'M',
        ]);

        DB::table('sizes')->insert([
            'size' => 'G',
        ]);

        DB::table('sizes')->insert([
            'size' => 'GG',
        ]);
    }
}
