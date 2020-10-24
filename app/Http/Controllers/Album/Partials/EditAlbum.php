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
	protected $listeners = ['refreshAlbum', 'updateMeta'];

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
		$this->photos;
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('album.partials.edit-album');
	}

	/**
	 * Toggle a photo.
	 *
	 * @param Photo $photo
	 * @param boolean $checked
	 */
	public function togglePhoto(Photo $photo, bool $checked = null)
	{
		if($checked === null)
		{
			if($this->selectedPhotos->contains('id', $photo->id))
			{
				$this->removePhoto($photo);
			} else
			{
				$this->addPhoto($photo);
			}
		} else
		{
			if($checked)
			{
				if(!$this->selectedPhotos->contains('id', $photo->id))
				{
					$this->addPhoto($photo);
				}
			} else
			{
				if($this->selectedPhotos->contains('id', $photo->id))
				{
					$this->removePhoto($photo);
				}
			}
		}

		$this->emitUp('updateSelectedPhotos', $this->selectedPhotos);
	}

	/**
	 * Add a photo.
	 *
	 * @param Photo $photo
	 */
	private function addPhoto(Photo $photo)
	{
		$this->selectedPhotos->push($photo);
	}

	/**
	 * Remove a photo.
	 *
	 * @param Photo $photo
	 */
	private function removePhoto(Photo $photo)
	{
		$this->selectedPhotos = $this->selectedPhotos->filter(function($value) use($photo)
		{
			return $value['id'] !== $photo->id;
		});
	}

	/**
	 * Toggle all of the photos.
	 */
	public function toggleAll(bool $checked)
	{
		foreach($this->_photos as $photo)
		{
			$this->togglePhoto($photo, $checked);
		}
	}

	/**
	 * Listen to the 'refreshAlum' event.
	 */
	public function refreshAlbum()
	{
		// todo: figure out a better way
		// than just clearing the last
		$this->photos;
		$this->album->refresh();
		$this->selectedPhotos = collect();
	}
}
