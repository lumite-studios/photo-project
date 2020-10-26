<?php
namespace App\Traits;

use App\Models\Invite;

trait Invites
{
	/**
	 * Accept an invite.
	 *
	 * @param string $code
	 */
	public function acceptInvite(string $code)
	{
		$invite = $this->invites()->where('code', '=', $code)->first();
		return $this->joinFamily($invite->family, json_decode($invite->permissions));
	}

	/**
	 * Fetch any invites this user has.
	 *
	 * @return array
	 */
	public function invites()
	{
		return $this->hasMany(Invite::class, 'email_address', 'email');
	}
}
