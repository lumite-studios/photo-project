<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasPhoto
{
	/**
	 * The column name for the photo path.
	 * @var string
	 */
	// protected $photoColumn = 'profile_photo_path';

	/**
	 * The folder to store the photo in.
	 * @var string
	 */
	// protected $photoFolder = 'profile-photos';

    /**
     * Update a photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updatePhoto(UploadedFile $photo)
    {
        tap($this[$this->photoColumn], function ($previous) use ($photo) {
            $this->forceFill([
                [$this->photoColumn] => $photo->storePublicly(
                    [$this->photoFolder], ['disk' => $this->photoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->photoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete a photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        Storage::disk($this->photoDisk())->delete($this[$this->photoColumn]);

        $this->forceFill([
            [$this->photoColumn] => null,
        ])->save();
    }

    /**
     * Get the URL to a photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return $this[$this->photoColumn]
                    ? Storage::disk($this->photoDisk())->url($this[$this->photoColumn])
                    : $this->defaultPhotoUrl();
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

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function photoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }
}
