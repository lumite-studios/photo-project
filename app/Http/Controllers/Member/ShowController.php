<?php
namespace App\Http\Controllers\Member;

use App\Models\Photo;
use App\Traits\DisplayPhotos;
use Livewire\Component;

class ShowController extends Component
{
	use DisplayPhotos;

	/**
	 * The current member.
	 * @var Member
	 */
	public $member;

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
	protected $listeners = ['refresh' => '$refresh'];

	/**
	 * Setup the components required data.
	 *
	 * @param integer $member_id
	 */
	public function mount(int $member_id)
	{
		$this->member = $this->model = auth()->user()->currentFamily->members()->where('id', '=', $member_id)->first();
		$this->total = $this->member->photos->count();
		$this->photos;
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
        return view('member.show')
			->layout('layouts.app', [
				'title' => __('member/show.title').$this->member->name,
				'subtitle' => __('member/show.text.subtitle'),
			]);
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
