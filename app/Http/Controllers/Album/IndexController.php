<?php
namespace App\Http\Controllers\Album;

use Livewire\Component;
use Livewire\WithPagination;

class IndexController extends Component
{
	use WithPagination;

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
        return view('album.index')
			->layout('layouts.app', [
				'title' => __('album/index.title'),
				'subtitle' => __('album/index.text.subtitle'),
			]);
	}

	public function getAlbumsProperty()
	{
		return auth()->user()->currentFamily->albumsWithOptionalUnsorted()->orderBy('updated_at', 'DESC')->paginate(6);
	}
}
