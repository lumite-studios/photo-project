<?php

namespace App\Models;

use App\Models\Photo;
use App\Models\Tag;
use App\Traits\HasPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
	use HasFactory;
	use HasPhoto;

	/**
	 * The column name for the photo path.
	 * @var string
	 */
	protected $photoColumn = 'cover_photo_path';

	/**
	 * The folder to store the photo in.
	 * @var string
	 */
	protected $photoFolder = null;

	protected $dates = ['birthday'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable =
	[
		'description',
		'name',
	];

	/**
	 * Fetch all the photos this member is in.
	 *
	 * @return array
	 */
	public function photos()
	{
		return $this->hasManyThrough(Photo::class, Tag::class, 'member_id', 'id', 'id', 'photo_id');
	}

	/**
	 * Fetch all of the tags this member has.
	 *
	 * @return array
	 */
	public function tags()
	{
		return $this->hasMany(Tag::class);
	}
}
