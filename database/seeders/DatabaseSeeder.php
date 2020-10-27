<?php

namespace Database\Seeders;

use Database\Seeders\FixUnsorted;
use Database\Seeders\InitialUserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call([
			FixUnsorted::class,
		]);

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$this->call([
			InitialUserSeeder::class,
		]);
    }
}
