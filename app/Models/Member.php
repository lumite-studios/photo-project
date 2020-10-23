<?php

namespace App\Models;

use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
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
     * Get the URL to a photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photos()->first()->photo_url;
	}

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
