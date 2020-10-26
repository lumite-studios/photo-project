<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if($user = User::where('email', '=', config('app.initial_user_email')->first()))
		{
			return;
		}

		User::create([
			'name' => config('app.initial_user_name'),
			'email_address' => config('app.initial_user_email'),
			'password' => Hash::make(config('app.initial_user_password')),
		]);
    }
}
