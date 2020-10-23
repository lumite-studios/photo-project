<?php

namespace App\Models;

use App\Models\Photo;
use App\Traits\HasPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
	use HasPhoto;

	/**
	 * The column name for the photo path.
	 * @var string
	 */
	protected $photoColumn = 'cover_photo_path';

	/**
	 * The column name to user for the name.
	 * @var string
	 */
	protected $photoName = 'name';

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
		'cover_photo_path',
		'description',
		'duplicate_check',
		'editable',
		'name',
		'slug',
	];

	/**
	 * Fetch all of the photos in this album.
	 *
	 * @return array
	 */
	public function photos()
	{
		return $this->hasMany(Photo::class);
	}

    /**
     * Get the default photo URL if no photo has been uploaded.
     *
     * @return string
     */
    protected function defaultPhotoUrl()
    {
		return 'https://dummyimage.com/500/EBF4FF/7F9CF5';
    }
}
