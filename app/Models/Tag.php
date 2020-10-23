<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable =
	[
		'left',
		'top',
	];

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'photos_tags';

	/**
	 * Fetch the member this tag is of.
	 *
	 * @return object
	 */
	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	/**
	 * Fetch the photo this tag is on.
	 *
	 * @return object
	 */
	public function photo()
	{
		return $this->belongsTo(Photo::class);
	}
}
