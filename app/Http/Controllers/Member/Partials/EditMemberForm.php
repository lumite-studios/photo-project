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
		'name' => null,
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
			'name' => $this->member->name,
		];
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('member.partials.edit-member-form');
	}

	/**
	 * Update this member.
	 */
	public function update()
	{
		$this->validate([
			'state' => ['array', 'required'],
			'state.name' => ['required', 'string'],
		]);

		$this->member->name = $this->state['name'];
		$this->member->save();

		$this->emit('refreshMember');
	}

	/**
	 * Delete this member.
	 */
	public function delete()
	{
		Member::where('id', '=', $this->member->id)->first()->delete();
		return redirect()->route('member.index');
	}
}
