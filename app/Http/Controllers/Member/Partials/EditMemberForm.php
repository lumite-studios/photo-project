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
			'description' => $this->member->description,
			'birthday' => $this->member->birthday !== null ? $this->member->birthday->format('Y-m-d') : null,
			'mother' => null,
			'father' => null,
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
		if(auth()->user()->canEdit())
		{
			$this->validate([
				'state' => ['array', 'required'],
				'state.name' => ['required', 'string'],
				'state.description' => ['nullable', 'string'],
				'state.birthday' => ['date', 'nullable'],
			]);

			$this->member->name = $this->state['name'];
			$this->member->description = $this->state['description'];
			$this->member->birthday = $this->state['birthday'];
			$this->member->save();

			$this->emit('toast', __('member/show.text.updated-member'), 'success');
			$this->emit('refreshMember');
		}
	}

	/**
	 * Delete this member.
	 */
	public function delete()
	{
		if(auth()->user()->canDelete())
		{
			Member::where('id', '=', $this->member->id)->first()->delete();
			$this->emit('toast', __('member/show.text.deleted-member'), 'success');
			return redirect()->route('member.index');
		}
	}
}
