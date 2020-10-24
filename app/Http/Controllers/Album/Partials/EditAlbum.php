<?php
namespace App\Http\Controllers\Album\Partials;

use App\Models\Album;
use App\Models\Photo;
use App\Traits\DisplayPhotos;
use Livewire\Component;

class EditAlbum extends Component
{
	use DisplayPhotos;

	/**
	 * The current album.
	 * @var Album
	 */
	public $album;

	/**
	 * Whether the album can be edited.
	 * @var boolean
	 */
	public $canEdit = false;

	/**
	 * The selected photos that exist in the album.
	 * @var Collection
	 */
	public $selectedPhotos;

	/**
	 * An array of listeners for events.
	 * @var array
	 */
	protected $listeners = ['updateMeta'];

	/**
	 * Setup the components required data.
	 *
	 * @param Album $album
	 */
	public function mount(Album $album)
	{
		$this->album = $this->model = $album;
		$this->canEdit = $this->album->editable;
		$this->selectedPhotos = collect();
		$this->total = $this->album->photos->count();
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('album.partials.edit-album');
	}

	public function togglePhoto(Photo $photo)
	{
		if($this->selectedPhotos->contains('id', $photo->id))
		{
			$this->selectedPhotos = $this->selectedPhotos->filter(function($value) use($photo)
			{
				return $value['id'] !== $photo->id;
			});
		} else
		{
			$this->selectedPhotos->push($photo);
		}

		$this->emitUp('updateSelectedPhotos', $this->selectedPhotos);
	}
}
