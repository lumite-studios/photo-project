<?php
namespace App\Http\Controllers\Member;

use Livewire\Component;

class CreateController extends Component
{
	/**
	 * The create form data.
	 * @var array
	 */
	public $state = [
		'name' => '',
	];

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
        return view('member.create')
			->layout('layouts.app', [
				'title' => __('member/create.title'),
				'subtitle' => __('member/create.text.subtitle'),
			]);
	}

	/**
	 * Create the member.
	 */
	public function create()
	{
		$this->validate([
			'state' => ['array', 'required'],
			'state.name' => ['max:255', 'required', 'string'],
		]);

		$member = auth()->user()->currentFamily->members()->create([
			'name' => $this->state['name'],
		]);

		return redirect()->route('member.index', ['member_id' => $member->id]);
	}
}
