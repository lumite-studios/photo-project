<?php
namespace App\Http\Controllers\Album\Partials;

use App\Models\Album;
use App\Models\Photo;
use Livewire\Component;
use Livewire\WithPagination;

class ViewAlbum extends Component
{
	use WithPagination;

	/**
	 * The current album.
	 * @var Album
	 */
	public $album;

	/**
	 * The number of photos to show per row.
	 * @var integer
	 */
	public $amount;

	/**
	 * The number of photos.
	 * @var integer
	 */
	public $total;

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
	protected $listeners = ['updatePaginate'];

	/**
	 * Setup the components required data.
	 *
	 * @param Album $album
	 * @param integer $amount
	 * @param integer $total
	 */
	public function mount(Album $album, int $amount, int $total)
	{
        $this->resetPage();
		$this->album = $album;
		$this->amount = $amount;
		$this->total = $total;
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
		return view('album.partials.view-album', [
			'photos' => $this->album->photos()->paginate($this->total),
		]);
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

	/**
	 * Update the pagination.
	 *
	 * @param integer $total
	 */
	public function updatePaginate(int $total)
	{
		$this->total = $total;
        $this->resetPage();
		$this->photos = $this->album->photos()->paginate($this->total);
	}
}
