<?php
namespace App\Http\Controllers\Album;

use Livewire\Component;

class ShowController extends Component
{
	/**
	 * The current album.
	 * @var Album
	 */
	public $album;

	/**
	 * Setup the components required data.
	 *
	 * @param string $album_slug
	 */
	public function mount(string $album_slug)
	{
		$this->album = auth()->user()->currentFamily->albums()->where('slug', '=', $album_slug)->first();
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
        return view('album.show')
			->layout('layouts.app', [
				'title' => __('album/show.title').$this->album->name,
				'subtitle' => $this->album->description,
			]);
	}
}
