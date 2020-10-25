<?php
namespace App\Http\Controllers\Family;

use Livewire\Component;

class IndexController extends Component
{
	/**
	 * The form state.
	 * @var array
	 */
	public $state = [
		'name' => null,
	];

	/**
	 * Setup the components required data.
	 */
	public function mount()
	{
		$this->state['name'] = auth()->user()->currentFamily->name;
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
		return view('family.index')
			->layout('layouts.app', [
				'title' => __('family/index.title'),
				'subtitle' => __('family/index.text.subtitle'),
			]);
	}
}
