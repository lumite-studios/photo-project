<?php
namespace App\Http\Controllers\Album\Partials;

use App\Models\Album;
use App\Models\Photo;
use App\Traits\DisplayPhotos;
use Livewire\Component;

class ViewAlbum extends Component
{
	use DisplayPhotos;

	/**
	 * The current album.
	 * @var Album
	 */
	public $album;

	/**
	 * Whether to show the viewing photo modal.
	 * @var boolean
	 */
	public $showViewingPhotoModal = false;

	/**
	 * The currently selected photo to view.
	 * @param Photo
	 */
	public $viewPhoto;

	/**
	 * An array of listeners for events.
	 * @var array
	 */
	protected $listeners = ['refreshAlbum', 'updateMeta'];

	/**
	 * Setup the components required data.
	 *
	 * @param Album $album
	 * @param integer $amount
	 */
	public function mount(Album $album)
	{
		$this->album = $this->model = $album;
		$this->total = $this->album->photos->count();
		$this->photos;
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
		return view('album.partials.view-album');
	}

	/**
	 * Refresh the album.
	 */
	public function refreshAlbum()
	{
		$this->album->refresh();
	}

	/**
	 * Toggle the viewing photo modal.
	 *
	 * @param Photo $photo
	 */
	public function toggleViewingPhotoModal(Photo $photo)
	{
		$this->viewPhoto = $photo;
		$this->showViewingPhotoModal = true;
	}
}
