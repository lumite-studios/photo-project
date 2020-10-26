<?php

namespace App\Models;

use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable =
	[
		'code',
		'email',
		'permissions',
	];

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'families_invites';

	/**
	 * Fetch the family this invite code is for.
	 *
	 * @return object
	 */
	public function family()
	{
		return $this->belongsTo(Family::class);
	}
}
