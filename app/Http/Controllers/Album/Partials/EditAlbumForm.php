<?php
namespace App\Http\Controllers\Album\Partials;

use App\Models\Album;
use Livewire\Component;

class EditAlbumForm extends Component
{
	/**
	 * The current album.
	 * @var Album
	 */
	public $album;

	/**
	 * The state of the album.
	 * @var array
	 */
	public $state = [
		'duplicate_check' => null,
		'description' => null,
		'name' => null,
	];

	/**
	 * Setup the components required data.
	 *
	 * @param Album $album
	 */
	public function mount(Album $album)
	{
		$this->album = $album;
		$this->state = [
			'duplicate_check' => $album->duplicate_check,
			'description' => $album->description,
			'name' => $album->name,
		];
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('album.partials.edit-album-form');
	}

	/**
	 * Delete an album.
	 */
	public function delete()
	{
		$unsorted = Album::where('editable', '=', false)->first();

		foreach($this->album->photos as $photo)
		{
			$photo->album()->associate($unsorted);
			$photo->save();
		}
	}

	/**
	 * Update the album.
	 */
	public function update()
	{
		$this->validate([
			'state' => 'array|required',
			'state.name' => 'required|string',
			'state.description' => 'nullable|string',
			'state.duplicate_check' => 'boolean',
		]);

		$this->album->name = $this->state['name'];
		$this->album->description = $this->state['description'];
		$this->album->duplicate_check = $this->state['duplicate_check'];
		$this->album->save();

		$this->emit('refreshAlbum');
	}
}
