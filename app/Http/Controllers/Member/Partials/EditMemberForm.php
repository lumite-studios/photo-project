<?php
namespace App\Http\Controllers\Member\Partials;

use App\Models\Member;
use Livewire\Component;

class EditMemberForm extends Component
{
	/**
	 * The current member.
	 * @var Member
	 */
	public $member;

	/**
	 * The state of the album.
	 * @var array
	 */
	public $state = [
		//
	];

	/**
	 * Setup the components required data.
	 *
	 * @param Member $member
	 */
	public function mount(Member $member)
	{
		$this->member = $member;
		$this->state = [
			//
		];
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('member.partials.edit-member-form');
	}
}
