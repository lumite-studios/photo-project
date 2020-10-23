<?php
namespace App\Http\Controllers\Dashboard;

use Livewire\Component;

class IndexController extends Component
{
	/**
	 * The albums within the auth users current family.
	 * @var array
	 */
	public $albums = [];

	/**
	 * Whether the auth user has a family.
	 * @var boolean
	 */
	public $hasFamily;

	/**
	 * The members within the auth users current family.
	 * @var array
	 */
	public $members = [];

	/**
	 * Setup the components required data.
	 */
	public function mount()
	{
		if(auth()->user()->currentFamily !== null)
		{
			$this->hasFamily = true;
			$this->albums = auth()->user()->currentFamily->albumsWithOptionalUnsorted()->orderBy('updated_at', 'DESC')->take(4)->get();
			$this->members = auth()->user()->currentFamily->members()->whereHas('tags')->orderBy('updated_at', 'DESC')->take(4)->get();
		} else
		{
			$this->hasFamily = false;
		}
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
		return view('dashboard.index')
			->layout('layouts.app', [
				'title' => __('dashboard/index.title'),
				'subtitle' => __('dashboard/index.text.subtitle'),
			]);
	}
}
