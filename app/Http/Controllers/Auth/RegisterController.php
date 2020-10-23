<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
			'email_address' => ['max:255', 'email', 'required', 'unique:users,email_address'],
			'password' => ['confirmed', 'min:8', 'required'],
		]);

		$user = User::create([
			'name' => $data['name'],
			'email_address' => $data['email_address'],
			'password' => Hash::make($data['password']),
		]);

		return redirect()->route('auth.login');
	}
}
