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
	public $amount = 4;

	/**
	 * The number of photos to show per row.
	 * @var integer
	 */
	public $rows = 3;

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
	protected $listeners = ['updateRows'];

	/**
	 * Setup the components required data.
	 *
	 * @param Album $album
	 * @param integer $rows
	 */
	public function mount(Album $album, int $rows)
	{
		$this->album = $album;
		$this->rows = $rows;
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
		return view('album.partials.view-album', [
			'photos' => $this->album->photos()->paginate($this->amount * $this->rows),
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
	 * Update the rows.
	 *
	 * @param integer $rows
	 */
	public function updateRows(int $rows)
	{
		$this->rows = $rows;
		$this->photos = $this->album->photos()->paginate($this->amount * $this->rows);
	}
}
