<?php
namespace App\Traits;

use App\Models\Family;

trait Families
{
    /**
     * Check whether the user belongs to a family.
     *
     * @param Family $family
     * @return bool
     */
    public function belongsToFamily(Family $family)
    {
		return $this->families->contains(function($f) use($family)
		{
            return $f->id === $family->id;
        });
	}

	/**
	 * Fetch the current family.
	 *
	 * @return Family|null
	 */
    public function currentFamily()
    {
		// if the user doesn't have a current family...
		if(is_null($this->current_family_id))
		{
			// ..fetch their first family
			$family = $this->families()->first();

			// if it exists...
			if($family)
			{
				// ...switch to it
				$this->switchFamily($family);
			}
		}

		return $this->belongsTo(Family::class, 'current_family_id');
	}

	/**
	 * Get all of the families the user belongs to.
	 *
	 * @return
	 */
	public function families()
	{
		return $this->belongsToMany(Family::class, 'families_users')
						->withPivot(['permissions'])
						->withTimestamps();
	}

	public function family()
	{
		return $this->families()->where('families.id', '=', $this->current_family_id)->first();
	}

	/**
	 * Check if the user has a family.
	 *
	 * @return boolean
	 */
	public function hasFamily()
	{
		return $this->currentFamily !== null;
	}

	/**
	 * Check if a family is this users current family.
	 *
	 * @param Family $family
	 * @return boolean
	 */
	public function isCurrentFamily(Family $family)
	{
        return $family->id === $this->currentFamily->id;
	}

	/**
	 * Switch the user's current family.
	 *
	 * @param Family $family
	 * @return boolean
	 */
    public function switchFamily(Family $family)
    {
		// check if the user belongs to this family
		if(!$this->belongsToFamily($family))
		{
            return false;
        }

		// update the current family id
        $this->forceFill([
            'current_family_id' => $family->id,
        ])->save();

		// update relation
        $this->setRelation('currentFamily', $family);

        return true;
    }
}
