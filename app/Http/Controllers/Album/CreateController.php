<?php
namespace App\Http\Controllers\Album;

use Illuminate\Support\Str;
use Livewire\Component;

class CreateController extends Component
{
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
			// set the attributes for the cover photo upload
			$driver = config('filesystems.default');
			$photoName = pathinfo($this->state['cover_photo']->getClientOriginalName(), PATHINFO_FILENAME);
			$photoSlug = Str::slug($photoName)."-".time().'.'.$this->state['cover_photo']->getClientOriginalExtension();

			// set the path
			$path = $album->slug.'/'.$photoSlug;

			// save the path to the album
			$album->cover_photo_path = $path;
			$album->save();

			// create the photo
			$album->photos()->create([
				'name' => $photoName,
				'path' => $path,
			]);

			// store it
			$driver === 'local'
				? $this->state['cover_photo']->storeAs('public/'.$album->slug, $photoSlug)
				: $this->state['cover_photo']->storePubliclyAs($album->slug, $photoSlug);
		}

        return redirect('/albums/'.$album->slug);
	}
}
