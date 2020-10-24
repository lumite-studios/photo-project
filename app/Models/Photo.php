<?php

namespace App\Models;

use App\Models\Album;
use App\Models\Tag;
use App\Traits\HasPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
	use HasFactory;
	use HasPhoto;

	/**
	 * The column name for the photo path.
	 * @var string
	 */
	protected $photoColumn = 'path';

	/**
	 * The folder to store the photo in.
	 * @var string
	 */
	protected $photoFolder = null;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable =
	[
		'date_taken',
		'editable',
		'height',
		'name',
		'path',
		'width',
	];

	/**
	 * Fetch the album this photo belongs in.
	 *
	 * @return object
	 */
	public function album()
	{
		return $this->belongsTo(Album::class);
	}

	/**
	 * Fetch all of the tags this photo has.
	 *
	 * @return array
	 */
	public function tags()
	{
		return $this->hasMany(Tag::class);
	}
}
