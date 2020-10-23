<?php
namespace App\Http\Controllers\Member;

use App\Models\Photo;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ShowController extends Component
{
	/**
	 * The current count of photos.
	 * @var integer
	 */
	public $count;

	/**
	 * The current member.
	 * @var Member
	 */
	public $member;

	/**
	 * The number of months to load each time.
	 * @var integer
	 */
	private $months = 3;

	/**
	 * The date of the last loaded photo.
	 * @var string
	 */
	public $last = null;

	/**
	 * Whether to show the viewing photo modal.
	 * @var boolean
	 */
	public $showViewingPhotoModal = false;

	/**
	 * The meta state.
	 * @var array
	 */
	public $state = [
		'group' => [
			'value' => 'month',
			'options' => ['year', 'month', 'day'],
		],
		'sort' => [
			'value' => '>',
			'options' => ['>' => 'newest', '<' => 'oldest']
		],
	];

	/**
	 * The total number of photos.
	 * @var integer
	 */
	public $total;

	/**
	 * The currently selected photo to view.
	 * @param Photo
	 */
	public $viewPhoto;

	/**
	 * Setup the components required data.
	 *
	 * @param integer $member_id
	 */
	public function mount(int $member_id)
	{
		$this->member = auth()->user()->currentFamily->members()->where('id', '=', $member_id)->first();
		$this->total = $this->member->photos->count();
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
        return view('member.show', ['photos' => $this->getPhotos()])
			->layout('layouts.app', [
				'title' => __('member/show.title').$this->member->name,
				'subtitle' => __('member/show.text.subtitle'),
			]);
	}

	/**
	 * Show the next months.
	 */
	public function showNextMonths()
	{
		$this->photos = $this->getPhotos();
	}

	/**
	 * Set the last photos loaded to null if needed.
	 *
	 * @param mixed $val
	 */
	public function updatedState($val)
	{
		if(array_key_exists($val, $this->state['sort']['options']))
		{
			$this->last = null;
		}
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
	 * Handle generating the photos.
	 *
	 * @return Collection
	 */
	private function getPhotos()
	{
		// set the order base on the sort
		$sort = $this->state['sort']['value'];
		$order = $sort === '<' ? 'ASC' : 'DESC';
		$grouping = ['year' => 'Y', 'month' => 'F Y', 'day' => 'jS F Y'][$this->state['group']['value']];

		$first = $this->member->photos()->orderBy('date_taken', $order)->first();
		$this->last = $this->last === null
				? ($this->state['sort']['value'] === '>'
					? Carbon::parse($first['date_taken'])->subMonths($this->months)->toDateTimeString()
					: Carbon::parse($first['date_taken'])->addMonths($this->months)->toDateTimeString()
				)
				: ($this->state['sort']['value'] === '>'
					? Carbon::parse($this->last)->subMonths($this->months)->toDateTimeString()
					: Carbon::parse($this->last)->addMonths($this->months)->toDateTimeString()
				);

		$photos = $this->member->photos()
							->orderBy('date_taken', $order)
							->orderBy('id', $order)
							->whereDate('date_taken', $sort, $this->last)
							->get();

		$this->count = $photos->count();

		return $photos->groupBy(function($value, $key) use($grouping) {
			return Carbon::parse($value->date_taken)->format($grouping);
		});
	}
}
