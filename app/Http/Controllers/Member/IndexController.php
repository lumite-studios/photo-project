<?php
namespace App\Http\Controllers\Member;

use Livewire\Component;
use Livewire\WithPagination;

class IndexController extends Component
{
	use WithPagination;

	/**
	 * The amount to paginate by.
	 * @var integer
	 */
	private $amount = 8;

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
        return view('member.index')
			->layout('layouts.app', [
				'title' => __('member/index.title'),
				'subtitle' => __('member/index.text.subtitle'),
			]);
	}

	/**
	 * Get the members as a computed property.
	 */
	public function getMembersProperty()
	{
		return auth()->user()->currentFamily->members()->orderBy('updated_at', 'DESC')->paginate($this->amount);
	}
}
