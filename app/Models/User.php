<?php
namespace App\Models;

use App\Traits\Families;
use App\Traits\HasPhoto;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use Families;
	use HasFactory;
	use HasPhoto;

	/**
	 * The column name for the photo path.
	 * @var string
	 */
	protected $photoColumn = 'profile_photo_path';

	/**
	 * The folder to store the photo in.
	 * @var string
	 */
	protected $photoFolder = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable =
	[
        'name',
        'email_address',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	protected $hidden =
	[
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
	protected $casts =
	[
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the default photo URL if no photo has been uploaded.
     *
     * @return string
     */
    protected function defaultPhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
	}

	/**
	 * Does the user have "admin" privileges?
	 *
	 * @return boolean
	 */
	public function canAdmin()
	{
		return $this->hasPermission('admin');
	}

	/**
	 * Can the user delete resources?
	 *
	 * @return boolean
	 */
	public function canDelete()
	{
		return $this->hasPermission('delete');
	}

	/**
	 * Can the user edit resources?
	 *
	 * @return boolean
	 */
	public function canEdit()
	{
		return $this->hasPermission('edit');
	}

	/**
	 * Can the user invite others?
	 *
	 * @return boolean
	 */
	public function canInvite()
	{
		return $this->hasPermission('invite');
	}

	/**
	 * Can the user upload photos?
	 *
	 * @return boolean
	 */
	public function canUpload()
	{
		return $this->hasPermission('upload');
	}

	/**
	 * Can the user view resources?
	 *
	 * @return boolean
	 */
	public function canView()
	{
		return $this->hasPermission('view');
	}

	/**
	 * Get the users permission with their current family.
	 *
	 * @return Collection
	 */
	public function getPermissions()
	{
		return collect(json_decode($this->families()->where('families.id', '=', $this->currentFamily->id)->first()->pivot->permissions));
	}

	/**
	 * Does the user have a permission?
	 *
	 * @param string $permission
	 * @return boolean
	 */
	public function hasPermission(string $permission)
	{
		$permissions = $this->getPermissions();
		return $permissions->contains('*') ? true : $permissions->contains($permission);
	}

	public function hasAllPermissions()
	{
		return $this->getPermissions()->contains('*');
	}
}
