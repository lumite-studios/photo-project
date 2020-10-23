<?php
namespace App\Http\Controllers\Album;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowController extends Component
{
	use WithFileUploads;
	use WithPagination;

	/**
	 * The current album.
	 * @var Album
	 */
	public $album;

	/**
	 * The number of items to show per row.
	 * @var integer
	 */
	public $amount = 4;

	/**
	 * Whether the album can have photos uploaded.
	 * @var boolean
	 */
	public $canUpload = false;

	/**
	 * Whether the album is being edited.
	 * @var boolean
	 */
	public $editing = true;

	/**
	 * The various display options.
	 * @var array
	 */
	public $meta = [
		'paginate' => [
			'value' => 12,
			'options' => [12, 24, 48],
		],
	];

	/**
	 * The photos within the album.
	 * @var Collection
	 */
	public $photos;

	/**
	 * The selected photos that exist in the album.
	 * @var Collection
	 */
	public $selectedPhotos;

	/**
	 * Whether to show the uploading photos modal.
	 * @var boolean
	 */
	public $showUploadingPhotosModal = false;

	/**
	 * The upload form data.
	 * @var array
	 */
	public $state = [
		'photos' => [],
	];

	/**
	 * An array of listeners for events.
	 * @var array
	 */
	protected $listeners = ['toggleUploadingPhotosModal'];

	/**
	 * Setup the components required data.
	 *
	 * @param string $album_slug
	 */
	public function mount(string $album_slug)
	{
		$this->album = auth()->user()->currentFamily->albums()->where('slug', '=', $album_slug)->first();
		$this->canUpload = $this->album->editable;
		$this->selectedPhotos = collect();
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

	/**
	 * Toggle the editing state.
	 */
	public function toggleEditing()
	{
		$this->editing = !$this->editing;
	}

	/**
	 * Show the uploading photos modal.
	 */
	public function toggleUploadingPhotosModal()
	{
		$this->showUploadingPhotosModal = true;
	}

	/**
	 * Handle uploading the photos.
	 */
	public function upload()
	{
        $this->validate([
			'state.photos' => ['array', 'required'],
            'state.photos.*' => ['image'],
		]);

		$driver = config('filesystems.default');

		foreach($this->state['photos'] as $photo)
		{
			// set variables
			$name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
			$slug = Str::slug($name)."-".time().'.'.$photo->getClientOriginalExtension();
			$path = $this->album->slug.'/'.$slug;
			list($height, $width) = getimagesize($photo->getRealPath());
			$dateTaken = array_key_exists('DateTimeOriginal', exif_read_data($photo->getRealPath()))
				? exif_read_data($photo->getRealPath())['DateTimeOriginal']
				: (array_key_exists('FileDateTime', exif_read_data($photo->getRealPath()))
					? \Carbon\Carbon::parse(exif_read_data($photo->getRealPath())['FileDateTime'])->format('Y-m-d H:m:s')
					: null
				);

			// store it
			$driver === 'local' ? $photo->storeAs('public/'.$this->album->slug, $slug) : $photo->storePubliclyAs($this->album->slug, $slug);

			// create the photo
			$photo = $this->album->photos()->create([
				'date_taken' => $dateTaken,
				'height' => $height,
				'name' => $name,
				'path' => $path,
				'width' => $width,
			]);
		}

		$this->showUploadingPhotosModal = false;
		$this->state['photos'] = [];
		$this->emit('refreshAlbum');
	}
}
