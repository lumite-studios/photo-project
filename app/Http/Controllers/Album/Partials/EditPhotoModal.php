<?php
namespace App\Http\Controllers\Album\Partials;

use App\Models\Member;
use App\Models\Photo;
use App\Models\Tag;
use Livewire\Component;

class EditPhotoModal extends Component
{
	public $members;

	/**
	 * A new tag being created.
	 * @var Tag
	 */
	public $newTag;

	/**
	 * The currently selected photo.
	 * @var Photo
	 */
	public $photo;

	/**
	 * Whether to show the editing photo modal.
	 * @var boolean
	 */
	public $showEditingPhotoModal = false;

	/**
	 * The form state.
	 * @var array
	 */
	public $state = [];

	/**
	 * An array of listeners for events.
	 * @var array
	 */
	protected $listeners = ['selectedSearch', 'startEditingPhoto'];

	/**
	 * Setup the components required data.
	 */
	public function mount()
	{
		$this->clearState();
		$this->members = Member::all();
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('album.partials.edit-photo-modal');
	}

	public function clearState()
	{
		$this->state = [
			'cover_photo' => null,
			'name' => null,
			'description' => null,
			'date_taken' => null,
		];
	}

	/**
	 * Start editing a photo.
	 *
	 * @param Photo $photo
	 */
	public function startEditingPhoto(Photo $photo)
	{
		$this->photo = $photo;
		$this->closeNewTag();
		$this->state = [
			'cover_photo' => $photo->album->cover_photo_path === $photo->path ? true : false,
			'name' => $photo->name,
			'description' => $photo->description,
			'date_taken' => \Carbon\Carbon::parse($photo->date_taken)->toDateTimeLocalString(),
		];

		$this->showEditingPhotoModal = true;
	}

	/**
	 * Start a new tag.
	 *
	 * @param integer $width
	 * @param integer $left
	 * @param integer $height
	 * @param integer $top
	 */
	public function startNewTag(int $width, int $left, int $height, int $top)
	{
		$this->newTag =
		[
			'member' => '',
			'left' => ($left / $width) * 100,
			'top' => ($top / $height) * 100,
		];
	}

	/**
	 * Close the new tag input.
	 */
	public function closeNewTag()
	{
		$this->newTag = null;
	}

	/**
	 * Create a new tag.
	 */
	public function createTag()
	{
		// is the member an array?
		if(is_array($this->newTag['member']))
		{
			$member = Member::where('id', '=', $this->newTag['member']['id'])->first();
		} else
		{
			$member = auth()->user()->currentFamily->members()->where('name', '=', $this->newTag['member'])->first();
			if(!$member)
			{
				$member = auth()->user()->currentFamily->members()->create([
					'name' => $this->newTag['member'],
				]);
			}
		}

		$tag = new Tag;
		$tag->left = $this->newTag['left'];
		$tag->top = $this->newTag['top'];
		$tag->photo()->associate($this->photo);
		$tag->member()->associate($member);
		$tag->save();

		$this->refreshPhoto();
		$this->closeNewTag();
	}

	/**
	 * Delete a tag.
	 *
	 * @param Tag $tag
	 */
	public function deleteTag(Tag $tag)
	{
		$tag->delete();
		$this->refreshPhoto();
	}

	/**
	 * Save changes to the photo.
	 */
	public function save()
	{
		$this->validate([
			'state' => 'array',
			'state.name' => 'required|string',
			'state.description' => 'nullable|string',
			'state.date_taken' => 'nullable',
			'state.cover_photo' => 'boolean',
		]);

		$this->photo->name = $this->state['name'];
		$this->photo->description = $this->state['description'];
		$this->photo->date_taken = $this->state['date_taken'];
		$this->photo->save();

		if($this->state['cover_photo'])
		{
			$this->photo->album->cover_photo_path = $this->photo->path;
			$this->photo->album->save();
		}

		$this->stopEditingPhoto();

		$this->emit('refreshAlbum');
	}

	/**
	 * Refresh the photo.
	 */
	public function refreshPhoto()
	{
		$this->photo->refresh();
	}

	/**
	 * Get the selected option from the search.
	 *
	 * @param mixed $selected
	 */
	public function selectedSearch($selected)
	{
		$this->newTag['member'] = $selected;
	}
}
