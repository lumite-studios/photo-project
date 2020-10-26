<?php
namespace App\Http\Controllers\Album;

use App\Jobs\UploadPhoto;
use App\Models\Album;
use App\Models\Photo;
use App\Traits\DisplayPhotosOptions;
use Illuminate\Support\Facades\Bus;
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
	 * Whether the album can be edited.
	 * @var boolean
	 */
	public $canEdit = false;

	/**
	 * Whether the album can have photos uploaded.
	 * @var boolean
	 */
	public $canUpload = false;

	/**
	 * Whether the album is being edited.
	 * @var boolean
	 */
	public $editing = false;

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
		$this->canEdit = $this->album->editable && auth()->user()->canEdit();
		$this->canUpload = $this->album->editable && auth()->user()->canUpload();
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

		$batches = [];
		$driver = config('filesystems.default');
		$duplicates = collect();

		foreach($this->state['photos'] as $photo)
		{
			// set variables
			$temp_path = config('livewire.temporary_file_upload.directory').'/'.$photo->getFilename();
			$name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
			$slug = Str::slug($name)."-".time().'.'.$photo->getClientOriginalExtension();
			$path = $this->album->slug.'/'.$slug;

			// calculate date taken from the photo
			$dateTaken = array_key_exists('DateTimeOriginal', exif_read_data($photo->getRealPath()))
				? exif_read_data($photo->getRealPath())['DateTimeOriginal']
				: (array_key_exists('FileDateTime', exif_read_data($photo->getRealPath()))
					? \Carbon\Carbon::parse(exif_read_data($photo->getRealPath())['FileDateTime'])->format('Y-m-d H:m:s')
					: null
				);

			// get a signature from the image
			$image = new \Imagick();
			$image->readImageBlob($photo->get());
			$signature = $image->getImageSignature();

			// create the photo
			$_photo = new Photo;
			$_photo->date_taken = $dateTaken;
			$_photo->name = $name;
			$_photo->path = $path;
			$_photo->signature = $signature;
			$_photo->temp_path = str_replace('public/', '', $temp_path);

			// are we NOT checking for duplicates?
			// or is the photo not a duplicate
			if(!$this->album->duplicate_check || ($this->album->duplicate_check && !$_photo->isDuplicate()))
			{
				$_photo = $this->album->photos()->create($_photo->toArray());

				// store it
				if($driver === 'local')
				{
					$photo->storeAs('public/'.$this->album->slug, $slug);
				} else
				{
					$batches[] = new UploadPhoto($_photo, $slug, $temp_path);
				}
			} else
			{
				$duplicates->push($_photo->name);
			}

		}

		if($duplicates->count() > 0)
		{
			$error = __('album/show.text.duplicates');
			$error .= '<ul>';
			foreach($duplicates as $dupe)
			{
				$error .= '<li>'.$dupe.'</li>';
			}
			$error .= '</ul>';
			$this->emit('toast', $error, 'error');
		}

		Bus::batch($batches)->onQueue('uploads')->dispatch();

		$this->showUploadingPhotosModal = false;
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
