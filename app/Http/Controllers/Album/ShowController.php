<?php
namespace App\Http\Controllers\Album;

use App\Models\Album;
use App\Models\Photo;
use App\Traits\DisplayPhotosOptions;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowController extends Component
{
	use DisplayPhotosOptions;
	use WithFileUploads;

	/**
	 * The current album.
	 * @var Album
	 */
	public $album;

	/**
	 * The albums these photos could be moved to.
	 * @var Collection
	 */
	public $availableAlbums = [];

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
	protected $listeners = ['toggleUploadingPhotosModal', 'updateSelectedPhotos'];

	/**
	 * Setup the components required data.
	 *
	 * @param string $album_slug
	 */
	public function mount(string $album_slug)
	{
		$this->album = auth()->user()->currentFamily->albums()->where('slug', '=', $album_slug)->first();
		$this->availableAlbums = auth()->user()->currentFamily->albumsWithoutUnsorted()->where('id', '!=', $this->album->id)->get();
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
		$this->selectedPhotos = collect();
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

	/**
	 * Update the selected photos.
	 *
	 * @param array $selectedPhotos
	 */
	public function updateSelectedPhotos($selectedPhotos)
	{
		$this->selectedPhotos = collect($selectedPhotos);
	}

	/**
	 * Delete the selected photos.
	 */
	public function deleteSelectedPhotos()
	{
		foreach($this->selectedPhotos as $photo)
		{
			$photo = Photo::where('id', '=', $photo['id'])->first();
			$photo->delete();
		}

		$this->selectedPhotos = collect();
		$this->emit('refreshAlbum');
	}

	/**
	 * Move the selected photos.
	 */
	public function moveSelectedPhotos(Album $album)
	{
		foreach($this->selectedPhotos as $photo)
		{
			$photo = Photo::where('id', '=', $photo['id'])->first();
			$photo->album()->associate($album);
			$photo->save();
		}

		$this->selectedPhotos = collect();
		$this->emit('refreshAlbum');
	}
}
