<?php
namespace App\Http\Controllers\Album;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateController extends Component
{
	use WithFileUploads;

	/**
	 * The create form data.
	 * @var array
	 */
	public $state = [
		'cover_photo' => null,
		'description' => '',
		'name' => '',
	];

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('album.create')
			->layout('layouts.app', [
				'title' => __('album/create.title'),
				'subtitle' => __('album/create.text.subtitle'),
			]);
	}

	/**
	 * Create an album.
	 */
	public function create()
	{
		$this->validate([
			'state' => ['array', 'required'],
			'state.cover_photo' => ['image', 'nullable'],
			'state.name' => ['max:255', 'required', 'string'],
			'state.description' => ['max:255', 'string'],
		]);

		$album = auth()->user()->currentFamily->albums()->create([
			'name' => $this->state['name'],
			'slug' => Str::slug($this->state['name']),
			'description' => $this->state['description'],
		]);

		// update the slug
		$album->slug = $album->id.'-'.$album->slug;
		$album->save();

		if($this->state['cover_photo'] !== null)
		{
			$photo = $this->state['cover_photo'];

			// set variables
			$name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
			$slug = Str::slug($name)."-".time().'.'.$photo->getClientOriginalExtension();
			$path = $album->slug.'/'.$slug;
			list($height, $width) = getimagesize($photo->getRealPath());
			$dateTaken = array_key_exists('DateTimeOriginal', exif_read_data($photo->getRealPath()))
				? exif_read_data($photo->getRealPath())['DateTimeOriginal']
				: (array_key_exists('FileDateTime', exif_read_data($photo->getRealPath()))
					? \Carbon\Carbon::parse(exif_read_data($photo->getRealPath())['FileDateTime'])->format('Y-m-d H:m:s')
					: null
				);

			// store it
			$driver = config('filesystems.default');
			$driver === 'local' ? $photo->storeAs('public/'.$album->slug, $slug) : $photo->storePubliclyAs($album->slug, $slug);

			// create the photo
			$album->photos()->create([
				'date_taken' => $dateTaken,
				'height' => $height,
				'name' => $name,
				'path' => $path,
				'width' => $width,
			]);

			$album->cover_photo_path = $path;
			$album->save();
		}

        return redirect()->route('album.show', ['album_slug' => $album->slug]);
	}
}
