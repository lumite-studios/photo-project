<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invite;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
	/**
	 * Show the register view.
	 *
	 * @return view
	 */
	public function index()
	{
		return view('auth.register');
	}

	/**
	 * Handle creating a new user account.
	 *
	 * @param Request $request
	 * @return redirect
	 */
	public function create(Request $request)
	{
		$data = $request->validate([
			'name' => ['max:255', 'required', 'string'],
			'invite_code' => ['filled', 'size:15', function($attribute, $value, $fail) {
				if(config('app.invite_code'))
				{
					return $value !== null;
				}
			}],
			'email_address' => ['max:255', 'email', 'required', 'unique:users,email_address'],
			'password' => ['confirmed', 'min:8', 'required'],
		]);

		$invite = null;

		if(array_key_exists('invite_code', $data))
		{
			$invite = Invite::where('email', '=', $data['email_address'])->where('code', '=', $data['invite_code'])->first();
			if(!$invite)
			{
				return redirect()->back()->withErrors(['incorrect_code' => __('validation.custom.incorrect_code')])->withInput();
			}
		}

		$user = User::create([
			'name' => $data['name'],
			'email_address' => $data['email_address'],
			'password' => Hash::make($data['password']),
		]);

		if($invite !== null)
		{

		}

		return redirect()->route('auth.login');
	}
}
