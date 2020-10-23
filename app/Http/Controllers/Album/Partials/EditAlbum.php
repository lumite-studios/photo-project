<?php
namespace App\Http\Controllers\Album\Partials;

use App\Models\Album;
use Livewire\Component;
use Livewire\WithPagination;

class EditAlbum extends Component
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
	 * The number of photos.
	 * @var integer
	 */
	public $total;

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
		$this->canEdit = $this->album->editable;
		$this->selectedPhotos = collect();
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('album.partials.edit-album', [
			'photos' => $this->album->photos()->paginate($this->total),
		]);
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
