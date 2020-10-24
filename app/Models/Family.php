<?php
namespace App\Models;

use App\Models\Album;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable =
	[
		'name',
	];

	/**
	 * Fetch all of the albums within this family.
	 *
	 * @return array
	 */
	public function albums()
	{
		return $this->hasMany(Album::class);
	}

	/**
	 * Fetch the albums and optionally included
	 * the "Unsorted" album, ONLY if it has photos.
	 *
	 * @return array
	 */
	public function albumsWithOptionalUnsorted()
	{
		return $this->hasMany(Album::class)
					->where(function($q) {
						$q->where('editable', '=', 1);
					})
					->orWhere(function($q) {
						$q->where('editable', '=', 0)->whereHas('photos');
					});
	}

	public function albumsWithoutUnsorted()
	{
		return $this->hasMany(Album::class)
					->where('editable', '=', 1);
	}

	/**
	 * Fetch all of the members in this family.
	 *
	 * @return array
	 */
	public function members()
	{
		return $this->hasMany(Member::class);
	}

	/**
	 * Get all of the users within this family.
	 *
	 * @return array
	 */
	public function users()
	{
		return $this->belongsToMany(User::class, 'families_users')
						->withPivot(['permissions'])
						->withTimestamps();
	}
}
