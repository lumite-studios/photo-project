<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/**
	 * Show the login view.
	 *
	 * @return view
	 */
	public function index()
	{
		return view('auth.login');
	}

	/**
	 * Handle logging a user into their account.
	 *
	 * @param Request $request
	 * @return redirect
	 */
	public function create(Request $request)
	{
		$data = $request->validate([
			'email_address' => ['email', 'required'],
			'password' => ['required'],
			'remember_me' => ['in:off,on'],
		]);

		$remember = array_key_exists('remember_me', $data) ? true : false;

		if(auth()->attempt(['email_address' => $data['email_address'], 'password' => $data['password']], $remember))
		{
			return redirect()->route('dashboard');
		} else
		{
			return redirect()->back()->withErrors(['failed' => 'failed']);
		}
	}
}
