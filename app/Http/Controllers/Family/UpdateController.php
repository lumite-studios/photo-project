<?php
namespace App\Http\Controllers\Family;

use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
	/**
	 * Switch the auth users current family.
	 *
	 * @param integer $family_id
	 */
	public function update(int $family_id)
	{
		$family = auth()->user()->families()->where('families.id', '=', $family_id)->first();

		if(!$family)
		{
			return redirect()->route('dashboard');
		}

		auth()->user()->switchFamily($family);
		return redirect()->route('dashboard');
	}
}
